<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

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
	}
	/**
	 * Replaces {backbutton} with a back button link
	 *
	 * Method is called by the view
	 *
	 * @param 	object		The article object.  Note $article->text is also available
	 * @param 	object		The article params
	 * @param 	int			The 'page' number
	 */
	function onPrepareContent( &$article, &$params, $limitstart = 0 )
	{
		global $mainframe;
		$this->params->get('showindiv') == 1 ? $link = '<div class="backbutton">' : $link = '';
		$pattern = '{backbutton}';
		$link .= '<a href="javascript:history.back();">'. $this->params->get('linklabel', JText::_('BACK')) .'</a>';
		$this->params->get('showindiv') == 1 ? $link .= '</div>' : $link .= '';
		$article->text = str_replace($pattern, $link, $article->text);
  }
}
?>