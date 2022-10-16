<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['assetic'] = array(
	'js' => array(
		//For every page
		'autoload' => array(
			'resources/jquery.js',
			'resources/bootstrap-3.2.0/js/bootstrap.min.js',
			'resources/select2-bootstrap/select2.min.js',                    
			'resources/js/comunes/printThis.js',
			'resources/mousetrap/mousetrap.min.js',                    
			'resources/mousetrap/plugins/global-bind/mousetrap-global-bind.min.js',                    
			'resources/js/libs/numeric/jquery.numeric.js',
			'resources/sweetalert/dist/sweetalert.min.js',
			'resources/toastr8/js/toastr8.min.js',
			'resources/eModal/dist/eModal.min.js',
			'resources/js/libs/jform/jquery.form.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/bootstrap-table.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/extensions/export/bootstrap-table-export.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/extensions/filter-control/bootstrap-table-filter-control.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/extensions/export/tableExport.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/extensions/mobile/bootstrap-table-mobile.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/extensions/resizable/bootstrap-table-resizable.js',
			'resources/bootstrap-table/assets/bootstrap-table/src/extensions/resizable/coresizable.js',
//			'resources/bootstrap-table/ga.js',
//			'resources/Se7en/javascripts/raphael.min.js',
			'resources/Se7en/javascripts/selectivizr-min.js',
			'resources/Se7en/javascripts/jquery.mousewheel.js',
//			'resources/Se7en/javascripts/jquery.vmap.min.js',
//			'resources/Se7en/javascripts/jquery.vmap.sampledata.js',
//			'resources/Se7en/javascripts/jquery.vmap.world.js',
			'resources/Se7en/javascripts/jquery.bootstrap.wizard.js',
//			'resources/Se7en/javascripts/fullcalendar.min.js',
//			'resources/Se7en/javascripts/gcal.js',
//			'resources/Se7en/javascripts/jquery.easy-pie-chart.js',
			'resources/Se7en/javascripts/excanvas.min.js',
			'resources/Se7en/javascripts/jquery.isotope.min.js',
			'resources/Se7en/javascripts/isotope_extras.js',
//			'resources/Se7en/javascripts/modernizr.custom.js',
//			'resources/Se7en/javascripts/jquery.fancybox.pack.js',
			'resources/Se7en/javascripts/styleswitcher.js',
			'resources/Se7en/javascripts/wysiwyg.js',
			'resources/Se7en/javascripts/summernote.min.js',
			'resources/Se7en/javascripts/jquery.inputmask.min.js',
//			'resources/Se7en/javascripts/jquery.validate.js',
			'resources/Se7en/javascripts/bootstrap-fileupload.js',
			'resources/Se7en/javascripts/bootstrap-datepicker.min.js',
			'resources/Se7en/javascripts/bootstrap-datepicker.es.js',
			'resources/Se7en/javascripts/bootstrap-timepicker.js',
//			'resources/Se7en/javascripts/bootstrap-colorpicker.js',
			'resources/Se7en/javascripts/bootstrap-switch.min.js',
			'resources/Se7en/javascripts/daterange-picker.js',
			'resources/Se7en/javascripts/date.js',
//			'resources/Se7en/javascripts/morris.min.js',
			'resources/Se7en/javascripts/skycons.js',
			'resources/Se7en/javascripts/fitvids.js',
			'resources/Se7en/javascripts/jquery.sparkline.min.js',
			'resources/Se7en/javascripts/main.js',
			'resources/Se7en/javascripts/respond.js',
//			'resources/owl.carousel/owl-carousel/owl.carousel.js',
//			'resources/owl.carousel/owl-carousel/owl.carousel.js',
			'resources/highchartTable/highcharts.js',
//			'resources/highchartTable/jquery.highchartTable.js',
			'resources/highchartTable/exporting.js',
			'resources/FullscreenSlitSlider/js/modernizr.custom.79639.js',                    
			'resources/FullscreenSlitSlider/js/jquery.ba-cond.min.js',
//			'resources/FullscreenSlitSlider/js/jquery.slitslider.js',
			'resources/js/modules/comunes.js',
		),
		'default-group'	=> 'scripts.min',
	),
	'css' => array(
		//For every page
		'autoload' => array(
                            'resources/Se7en/stylesheets/bootstrap.min.css', 
                            'resources/Se7en/stylesheets/font-awesome.css', 
                            'resources/Se7en/stylesheets/se7en-font.css',
                            'resources/Se7en/stylesheets/isotope.css',
//                            'resources/Se7en/stylesheets/jquery.fancybox.css',
//                            'resources/Se7en/stylesheets/fullcalendar.css',
                            'resources/Se7en/stylesheets/wizard.css',
//                            'resources/Se7en/stylesheets/morris.css',
                            'resources/Se7en/stylesheets/datepicker.min.css',
                            'resources/Se7en/stylesheets/timepicker.css',
//                            'resources/Se7en/stylesheets/colorpicker.css',
                            'resources/Se7en/stylesheets/bootstrap-switch.css',
                            'resources/Se7en/stylesheets/daterange-picker.css',
                            'resources/Se7en/stylesheets/summernote.css',
                            'resources/Se7en/stylesheets/pygments.css',
                            'resources/Se7en/stylesheets/style.css',                   
                            'resources/sweetalert/dist/sweetalert.css',
                            'resources/toastr8/css/toastr8.min.css',
                            'resources/css/style.css',
                            'resources/bootstrap-table/assets/bootstrap-table/src/bootstrap-table.css',
                            'resources/select2-bootstrap/select2.css',
                            'resources/select2-bootstrap/docs/css/select2-bootstrap.css',
//                            'resources/owl.carousel/owl-carousel/owl.carousel.css',
//                            'resources/owl.carousel/owl-carousel/owl.theme.css',
//                            'resources/FullscreenSlitSlider/css/style.css',
//                            'resources/FullscreenSlitSlider/css/custom.css',
                        ),
		'default-group'	=> 'styles.min'
	),
	'static' => array(
		//Directory where Assetic puts the merged files
		'dir' => 'assets/resources/',
	)
);