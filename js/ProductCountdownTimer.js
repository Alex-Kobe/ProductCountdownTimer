jQuery(function($) {
	window.update_countdown_preview_html = function() {
		if(ct_settings['Countdown Settings']['enabled'] == 1){
			const now = moment();
			const target = document.getElementById('ct_target');
			
			const cutoff_time_str = ct_settings['Countdown Settings']['cut_off_time'];
			const cutoff_mins = time_to_minutes(cutoff_time_str); // return integer mins from 00:00
			let cutoff_datetime = moment().startOf('day').add(cutoff_mins, 'minutes');
					
			// Declaring the shipping date variable
			let shipping_date = cutoff_datetime.clone();
			
			// If we are too late for todays cutoff_datetime, 1 day is added to the shipping date.
			let cutoff_diff = shipping_date.diff(now);
			if (cutoff_diff < 0) shipping_date.add(1, 'day');
			
			// If there are holidays on the days following this date, 1 day will be added recursively until there is no holiday
			const holidays = ct_settings['Holidays Settings'];

			const additional_days = ct_settings['Countdown Settings']['countdown_offset'];
			shipping_date = next_available_date(holidays, shipping_date, additional_days);
			
			let delivery_date = shipping_date.clone();
			delivery_date = next_available_date(holidays, delivery_date, 1);

			
			const countdown = moment.duration(shipping_date.diff(now));
			target.innerHTML = `Order within the next <font color="green"><b>${duration_label(countdown).replace('0 days', '') ? duration_label(countdown).replace('0 days', '') : duration_label(countdown)}</b></font>
						to get delivery on <font color="red"><b>${date_label(delivery_date)}</b></font>`;
		}
	}
	
	window.next_available_date = function(holidays, current_date, additional) {
		current_date.add(additional, 'day'); 
		let loop_1 = true;
		while(loop_1 == true){
			let loop_over_days = true;
			while (loop_over_days == true) {
				var changed = 0;
				holidays.forEach(holiday => {
					const holiday_date = holiday['date'];
					
					var conversion = current_date['_d'].toLocaleDateString();
					var conversion = moment(moment(conversion, 'DD/MM/YYYY')).format('YYYY-MM-DD');
					
					if (holiday_date === conversion) {
						current_date.add(1, 'day');
						changed++;
					}
				});
				
				// If changed variable has not changed, then this means that there are no holidays on this day, and the loop will end.
				if (changed == 0) loop_over_days = false;
			}
			
			let changed2 = 0;
			
			// If the shipping date falls on a weekend (Saturday & Sunday), then days are added to account for the fact that there is no shipping/delivery on weekends
			switch (current_date.format('dddd')) {
				case 'Saturday':   
					current_date.add(2, 'day'); 
					changed2++;
					break;
				case 'Sunday': 
					current_date.add(1, 'day'); 
					changed2++;
					break;
			}
			
			/**
			 * This is the end of this loop. 
			 * 
			 * This loop exists because if the shipping/delivery date has been changed in the last switch statement, 
			 * the new date (monday) may be a holiday. This means that "loop_over_days" loop will need to 
			 * be performed again to account for new potential holidays.
			 * 
			 * If the "changed2" variable equals 0, this means that the current day is not a weekend. This means that
			 * there will be no added days to account for no shipping/delivering on weekends and the loop will end
			 * since there will be no need to re-check for holidays.
			 */
			if(changed2 == 0) loop_1 = false;
		}

		return current_date;
	}

	window.duration_label = function(duration) {
		const days = duration.days();
		const hrs = duration.hours();
		const mins = duration.minutes();
		const secs = duration.seconds();
		return days + ' days ' + hrs + " hours "+mins+" minutes "+secs+" seconds";
	}

	window.date_label = function(datetime) {
		return datetime.format('dddd D MMM YYYY');
	}

	window.time_to_minutes = function(time) {
		var minutes = parseInt( time.split(':')[1] );
		var hours = parseInt( time.split(':')[0] );
		return minutes + (hours * 60);
	}

	setInterval(function() {
		update_countdown_preview_html();
	}, 1000);
});