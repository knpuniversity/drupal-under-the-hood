<?php

/**
 * @file
 * Contains \Drupal\devel\Tests\DevelSilentTest.
 */

namespace Drupal\devel\Tests;

use Drupal\Component\Serialization\Json;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\simpletest\WebTestBase;

/**
 * Tests devel silent.
 *
 * @group devel
 */
class DevelSilentTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['devel', 'devel_test', 'image', 'file'];

  /**
   * Tests devel silent.
   */
  public function testDevelSilent() {
    // TODO Quickfix for dynamic_page_cache, enabled by default in the testing
    // profile.
    $this->container->get('module_installer')->uninstall(['dynamic_page_cache']);

    $web_user = $this->drupalCreateUser([
      'administer site configuration',
      'access devel information',
      'administer software updates'
    ]);
    $this->drupalLogin($web_user);

    // Ensure that devel is disabled if response come from routes that are
    // declared with '_devel_silent' requirement.
    $this->drupalGet('devel-silent/route-requirement');
    $this->assertText(t('"_devel_silent" route requirement forces devel to be inactive.'));

    // Ensure that devel doesn't interfere with non html response (e.g JsonResponse).
    $response = $this->drupalGet('devel-silent/json');
    $this->assertResponse(200);
    $expected = ['data' => 'Devel is active only on HtmlResponse.'];
    $this->assertIdentical(Json::decode($response), $expected);

    // Ensure that devel doesn't interfere with private image style creation
    // and with BinaryFileResponse response.
    $style = ImageStyle::create([
      'name' => 'zyx',
      'label' => $this->randomString(),
    ]);
    $style->save();

    $image = current($this->drupalGetTestFiles('image'));
    $image_uri = file_unmanaged_copy($image->uri, 'private://');

    // Let the devel_test module know about this file, so it can claim
    // ownership in hook_file_download().
    \Drupal::state()->set('devel.test_file_download', $image_uri);

    $this->drupalGet($style->buildUrl($image_uri));
    $this->assertResponse(200);
    $this->assertRaw(file_get_contents($style->buildUri($image_uri)), 'URL returns expected file.');

    // Ensure that devel doesn't interfere with private files and with
    // BinaryFileResponse response.
    $file = File::create([
      'uid' => $web_user->id(),
      'filename' => 'drupal.txt',
      'uri' => 'private://devel.txt',
      'filemime' => 'text/plain',
      'status' => FILE_STATUS_PERMANENT,
    ]);
    file_put_contents($file->getFileUri(), 'Hello world!');
    $file->save();

    // Let the image_module_test module know about this file, so it can claim
    // ownership in hook_file_download().
    \Drupal::state()->set('devel.test_file_download', $file->getFileUri());

    $this->drupalGet($file->url());
    $this->assertResponse(200);
    $this->assertRaw(file_get_contents($file->getFileUri()), 'URL returns expected file.');
  }

}
