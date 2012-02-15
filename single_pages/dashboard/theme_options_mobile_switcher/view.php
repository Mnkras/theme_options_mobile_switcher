<?php   defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package Theme Options Mobile Switcher
 * @category Controller
 * @author Michael Krasnow <mnkras@gmail.com>
 * @copyright  Copyright (c) 2010-2012 Michael Krasnow (http://www.mnkras.com)
 * @license    http://www.concrete5.org/license/     MIT License
 */
$bt = Loader::helper('concrete/interface');
$valt = Loader::helper('validation/token');
$form = Loader::helper('form');

$alreadyActiveMessage = t('This theme is currently active for mobile devices.');
$check = ($mobile_enabled ? 'checked="checked"' : '');
?>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Enable Mobile Theme'), false, 'span12 offset2', false);?>
	<form method="post" id="mobile_enabled" action="<?php   echo View::url('dashboard/theme_options_mobile_switcher', 'mobile_enabled')?>">
		<?php   echo $valt->output('mobile_enabled')?>
		<div class="ccm-pane-body">
			<div class="clearfix inputs-list">
				<label for="MOBILE_ENABLED">
					<?php  echo $form->checkbox('MOBILE_ENABLED', 1, $mobile_enabled);?>	
					<span><?php   echo t('Mobile Theme Enabled')?></span>
				</label>
			</div>
		</div>
		<div class="ccm-pane-footer">
			<?php   echo $bt->submit(t('Save'), 'mobile_enabled', 'right', 'primary');?>
		</div>
	</form>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>
<br/>
<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Mobile Theme'), false, 'span12 offset2');?>
		
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="zebra-striped">
	<?php 
	if (count($tArray) == 0) { ?>
		
        <tbody>
            <tr>
                <td><p><?php echo t('No themes are installed.')?></p></td>
            </tr>        
		</tbody>
    
	<?php  } else { ?>
    
    	<tbody>
		
		<?php  foreach ($tArray as $t) { ?>        
        
            <tr <?php  if ($siteThemeID == $t->getThemeID()) { ?> class="ccm-theme-active" <?php  } ?>>
                
                <td>
					<div class="ccm-themes-thumbnail" style="padding:4px;background-color:#FFF;border-radius:3px;border:1px solid #DDD;">
						<?php echo $t->getThemeThumbnail()?>
					</div>
				</td>
                
                <td width="100%" style="vertical-align:middle;">
                
                    <p class="ccm-themes-name"><strong><?php echo $t->getThemeName()?></strong></p>
                    <p class="ccm-themes-description"><em><?php echo $t->getThemeDescription()?></em></p>
                    
                    <div class="ccm-themes-button-row clearfix">
                    <?php  if ($siteThemeID == $t->getThemeID()) { ?>
                        <?php echo $bt->button(t("Activate"), "javascript:void(0);", 'left', 'primary ccm-button-inactive ccm-tooltip', array('disabled'=>'disabled', 'title'=>$alreadyActiveMessage));?>
                    <?php  } else { ?>
                        <?php echo $bt->button(t("Activate"), $this->url('/dashboard/theme_options_mobile_switcher','activate_confirm', $t->getThemeID(), $valt->generate('activate_mobile')), 'left', 'primary');?>
                    <?php  } ?>
                        <?php echo $bt->button_js(t("Preview"), "ccm_previewInternalTheme(1, " . intval($t->getThemeID()) . ",'" . addslashes(str_replace(array("\r","\n",'\n'),'',$t->getThemeName())) . "')", 'left');?>

                    </div>
                
                </td>
            </tr>
            
		<?php  } ?>
        
        </tbody>
        
	<?php  } ?>
    
    </table>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper()?>