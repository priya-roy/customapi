<?php

namespace Drupal\customapi\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Custom route to show the page data.
 */
class CustomSiteApiKeyController extends ControllerBase {

  /**
   * The controller class for route right.
   *
   * String @param  $site_api_key - the API key parameter
   * Integer @param  NodeInterface - the node built from the node id parameter.
   * JSON @return  JsonResponse .
   */
  public function content($site_api_key, NodeInterface $node) {
    // Site API Key configuration value.
    $site_api_key_saved = \Drupal::config('system.site')->get('siteapikey');

    // Make sure the node is a page,the key is set and matches the supplied key.
    if ($node->getType() == 'page' && $site_api_key_saved != 'No API Key yet' && $site_api_key_saved == $site_api_key) {

      // Respond with the json representation of the node.
      return new JsonResponse($node->toArray(), 200, ['Content-Type' => 'application/json']);
    }

    // Respond with access denied.
    return new JsonResponse(["error" => "access denied"], 401, ['Content-Type' => 'application/json']);
  }

}
