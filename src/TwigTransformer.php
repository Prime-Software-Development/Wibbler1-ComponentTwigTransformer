<?php
namespace Trunk\Component\TwigTransformer;

use Trunk\EmailLibrary\EMail\transformer\BaseTransformer;
use Trunk\Wibbler\WibblerDependencyContainer;
use Trunk\EmailLibrary\EMail\Message;

class TwigTransformer extends BaseTransformer {

	/**
	 * @var WibblerDependencyContainer
	 */
	private $dependency_manager;

	/**
	 * @var \Trunk\Wibbler\Modules\twig
	 */
	private $twig;

	/**
	 * @var string
	 */
	private $template_location = "";

	public function __construct( $template_location ) {
		$this->template_location = $template_location;

		$this->dependency_manager = WibblerDependencyContainer::Instance();
		$this->twig = $this->dependency_manager->getService( "twig" );
	}

	/**
	 * @param Message $message
	 */
	public function transform( Message &$message ) {

		$params = $message->getParams();
		$params = array_merge( $params, [ 'body' => $message->getBody() ] );
		$message->setBody( $this->twig->render( $this->template_location, $params ) );
	}

}
