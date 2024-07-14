import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    connect() {
		console.log('Date controller connected');
		const datepicker = flatpickr("#date-picker", {
            enableTime: true,
            dateFormat: "Y-m-d H:i", // Format for date and time
            time_24hr: true // Use 24-hour format
		});
		datepicker.forEach(calendarInput => {
			const calendarContainer = calendarInput.calendarContainer;
			const calendarMonthNav = calendarInput.monthNav;
			const calendarNextMonthNav = calendarInput.nextMonthNav;
			const calendarPrevMonthNav = calendarInput.prevMonthNav;
			const calendarDaysContainer = calendarInput.daysContainer;
			calendarContainer.className = `${calendarContainer.className} bg-white p-4 border border-blue-gray-50 rounded-lg shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 focus:outline-none break-words whitespace-normal`;
			calendarMonthNav.className = `${calendarMonthNav.className} flex items-center justify-between mb-4 [&>div.flatpickr-month]:-translate-y-3`;
			calendarNextMonthNav.className = `${calendarNextMonthNav.className} absolute !top-2.5 !right-1.5 h-6 w-6 bg-transparent hover:bg-blue-gray-50 !p-1 rounded-md transition-colors duration-300`;
			calendarPrevMonthNav.className = `${calendarPrevMonthNav.className} absolute !top-2.5 !left-1.5 h-6 w-6 bg-transparent hover:bg-blue-gray-50 !p-1 rounded-md transition-colors duration-300`;
			calendarDaysContainer.className = `${calendarDaysContainer.className} [&_span.flatpickr-day]:!rounded-md [&_span.flatpickr-day.selected]:!bg-gray-900 [&_span.flatpickr-day.selected]:!border-gray-900`;
		});
    }
}
