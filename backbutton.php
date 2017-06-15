<?php
// no direct access
defined('_JEXEC') or die;

jimport( 'joomla.plugin.plugin' );

class plgContentBackButton extends JPlugin
{
	/**
	 * Constructor
	 *
	 *
	 * @param object $subject The object to observe
	 * @param object $params  The object that holds the plugin parameters
	 * @since 1.5
	 */
	function __construct( &$subject, $params )
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
		$link .= '<a href="javascript:history.back();"' . $aclass .'>'. $this->params->get('linklabel', JText::_('BBBACK')) .'</a>';
		$this->params->get('showindiv') == 1 ? $link .= '</div>' : $link .= '';
		$article->text = str_replace($pattern, $link, $article->text);
  }
}
?>
