<?php 

/*

 * This file contains the HTML generated for full calendars. You can copy this file to yourthemefolder/plugins/events-manager/templates and modify it in an upgrade-safe manner.

 * 

 * There are two variables made available to you: 

 * 

 * 	$calendar - contains an array of information regarding the calendar and is used to generate the content

 *  $args - the arguments passed to EM_Calendar::output()

 * 

 * Note that leaving the class names for the previous/next links will keep the AJAX navigation working.

 */

$cal_count = count($calendar['cells']); //to prevent an extra tr

$col_count = $tot_count = 1; //this counts collumns in the $calendar_array['cells'] array

$col_max = count($calendar['row_headers']); //each time this collumn number is reached, we create a new collumn, the number of cells should divide evenly by the number of row_headers

?>
<table class="em-calendar fullcalendar">

	<thead>

	</thead>

	<tbody>

		<tr class="days-names">

			<td><?php echo implode('</td><td>',$calendar['row_headers']); ?></td>

		</tr>

		<tr>

			<?php

			foreach($calendar['cells'] as $date => $cell_data ){

				$class = ( !empty($cell_data['events']) && count($cell_data['events']) > 0 ) ? 'eventful':'eventless';

				if(!empty($cell_data['type'])){

					$class .= "-".$cell_data['type']; 

				}

				//In some cases (particularly when long events are set to show here) long events and all day events are not shown in the right order. In these cases, 

				//if you want to sort events cronologically on each day, including all day events at top and long events within the right times, add define('EM_CALENDAR_SORTTIME', true); to your wp-config.php file 

				if( defined('EM_CALENDAR_SORTTIME') && EM_CALENDAR_SORTTIME ) ksort($cell_data['events']); //indexes are timestamps

				?>
			<style>td.eventful{background:linear-gradient(rgba(244,0,160,0.7),rgba(244,0,160,0.7)),url(http://bradvader.mythemecloud.io/wp-content/uploads/f256b391-ffec-381b-bcba-bc016e6fc582.jpg);background-size:cover;}</style>
				<td class="<?php echo esc_attr($class); ?>">

					<?php if( !empty($cell_data['events']) && count($cell_data['events']) > 0 ): ?>
					<a href="<?php echo esc_url($cell_data['link']); ?>" title="<?php echo esc_attr($cell_data['link_title']); ?>"><?php echo esc_html(date('j',$cell_data['date'])); ?></a>
<div class="dotw"><?php echo esc_html(date('l',$cell_data['date'])); ?></div>
					<ul>

						<?php echo EM_Events::output($cell_data['events'],array('format'=>get_option('dbem_full_calendar_event_format'))); ?>
						
						
						
						<?php if( $args['limit'] && $cell_data['events_count'] > $args['limit'] && get_option('dbem_display_calendar_events_limit_msg') != '' ): ?>

						<li><a href="<?php echo esc_url($cell_data['link']); ?>"><?php echo get_option('dbem_display_calendar_events_limit_msg'); ?></a></li>

						<?php endif; ?>

					</ul>

					<?php else:?>

					<?php echo esc_html(date('j',$cell_data['date'])); ?>

					<?php endif; ?>

				</td>

				<?php

				//create a new row once we reach the end of a table collumn

				$col_count= ($col_count == $col_max ) ? 1 : $col_count+1;

				echo ($col_count == 1 && $tot_count < $cal_count) ? '</tr><tr>':'';

				$tot_count ++; 

			}

			?>

		</tr>

	</tbody>

</table>
	<div class="custom_event_nav">
	<?php 
		
$dateObjPrev   = DateTime::createFromFormat('!m', $calendar['month_last']);
$monthNamePrev = $dateObjPrev->format('F');
$dateObjNext   = DateTime::createFromFormat('!m', $calendar['month_next']);
$monthNameNext = $dateObjNext->format('F');
		
		?>
	<div class="prev_month monthnav"><a class="em-calnav full-link em-calnav-prev" href="<?php echo esc_url($calendar['links']['previous_url']); ?>"><?php echo $monthNamePrev; ?></a>
		</div>
		<div class="this_month monthnav">
			<div class="month_name"><?php echo esc_html(date_i18n(get_option('dbem_full_calendar_month_format'), $calendar['month_start'])); ?></div>
		</div>
			<div class="next_month monthnav"><a class="em-calnav full-link em-calnav-next" href="<?php echo esc_url($calendar['links']['next_url']); ?>"><?php echo $monthNameNext; ?></a></div>

	</div>
