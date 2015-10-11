<?php
// no direct access
defined('_JEXEC') or die;

jimport( 'joomla.plugin.plugin' );

class plgContentBackButton extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param object $params  The object that holds the plugin parameters
	 * @since 1.5
	 */
	function plgContentBackbutton( &$subject, $params )
	{
		parent::__construct( $subject, $params );
		$this->loadLanguage();
	}
	/**
	 * Replaces {backbutton} with a back button link
	 *
	 * Method is called by the view
	 *
	 * 
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The article object.  Note $article->text is also available
	 * @param	object	The article params
	 * @param	int		The 'page' number
	 *
	 **/
	 
	function onContentPrepare( $context, &$article, &$params, $page=0 )
	{
		$app = JFactory::getApplication();
		$this->params->get('showindiv') == 1 ? $link = '<div class="backbutton">' : $link = '';
		$this->params->get('linkclass') == 1 ? $aclass = 'class="backbutton"' : $aclass = '';
		$pattern = '{backbutton}';
		
		

		////
		////// OOBA EDIT
		//////// Changes to allow the choice of always using history.back, or if the user arrives from a different site (search engine)
		//////// then the link will be generated from the site structure
		
		// REFERENCE LINKS
		// http://joomla.stackexchange.com/questions/4475/if-url-is-equal-to-x-then-do-this/4477#4477
		// https://docs.joomla.org/JURI/toString		
		if ($this->params->get('standardLinkStructure') == 1)
		{
		$link .= '<a href="javascript:history.back();"' . $aclass .'>'. $this->params->get('linklabel', JText::_('BBBACK')) .'</a>';	
		}
		else
		{
		$getRefererPage = $_SERVER['HTTP_REFERER'];
		$convertRefererPage = JURI::getInstance($getRefererPage);
		$sanitizeRefererPage = htmlspecialchars( $convertRefererPage->toString() );
		
		$currentURL = JURI::getInstance(); // Gets the current url
		$justHost = $currentURL->toString( array( 'host' ) ); // www. to .co.uk
		$justScheme = $currentURL->toString( array( 'scheme' ) ); // http or https
		$urlWithoutScheme = $currentURL->toString( array( 'host', 'path' ) ); // whole domain minus the scheme 
		
			if (strpos($sanitizeRefererPage,$justHost) !== false) {
				$link .= '<a href="javascript:history.back();"' . $aclass .'>'. $this->params->get('linklabel', JText::_('BBBACK')) .'</a>';
			}
			else
			{
			$split_url = explode('/', $urlWithoutScheme); // Turns the URL into an array
			$split_urlMinusLast = array_pop($split_url); // Removes last array item
			$newBackUrl = $justScheme . implode('/', $split_url); // Puts the ARRAY back to a URL and adds in the scheme
			
			$link .= '<a href="' . $newBackUrl . '"' . $aclass .'>'. $this->params->get('linklabel', JText::_('BBBACK')) .'</a>';
			}
		}	
		// END OF EDIT
		

		$this->params->get('showindiv') == 1 ? $link .= '</div>' : $link .= '';
		$article->text = str_replace($pattern, $link, $article->text);
  }
}
?>
