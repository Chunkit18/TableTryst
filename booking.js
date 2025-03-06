'use strict';

// DATA TABLE (Powered by List.js)
$(function() {
	var sortableClassValues = ['id', 'alt-id', 'samples', 'created-date', 'due-date', 'status'],
      pageRecordCount = $('#change-record-count option:selected').val(),
      activeFilters = [];

	var paginationOptions = {
		name: "pager",
		paginationClass: "pager",
		innerWindow: 1,
		left: 5,
		right: 1
	};

	var listOptions = {
		valueNames: sortableClassValues,
		page: pageRecordCount,
		plugins: [
			ListPagination(paginationOptions)
		]
	};

	var dataList = new List('datatable', listOptions);


	// Shown Entries select box listeners
	$('#change-record-count').change(function() {
		pageRecordCount = $('#change-record-count option:selected').val();

		dataList.page = pageRecordCount;

		dataList.update();

		$('.pager li:first').trigger('click');

		console.log('Shown Entries has changed to ' + pageRecordCount + ' per page...');

		checkPagerPosition();
	});

	// Filter Checkboxes
	$('.filter').change(function() {
		var isChecked = this.checked;
		var value = $(this).data("value");

		if (isChecked) {
			//  Add to list of active filters
			activeFilters.push(value);
		} else {
			// Remove from active filters
			activeFilters.splice(activeFilters.indexOf(value), 1);
		}
		console.log('Active filters are "' + activeFilters + '"...');

		dataList.filter(function(item) {
			if (activeFilters.length > 0) {
				return (activeFilters.indexOf(item.values().status)) > -1;
			}
			return true;
		});

		dataList.update();

		checkPagerPosition();

	});

	// PAGINATION PAGER CONTROLS

	// Previous button
	$('.prev').on('click', function() {
    var pagerLi = $('.pager').find('li');
		$.each(pagerLi, function(position, element) {
			if ($(element).is('.active')) {
				$(pagerLi[position - 1]).trigger('click');
			}
		});
		checkPagerPosition();
	});

	// Next button
	$('.next').on('click', function() {
    var pagerLi = $('.pager').find('li');
		$.each(pagerLi, function(position, element) {
			if ($(element).is('.active')) {
				$(pagerLi[position + 1]).trigger('click');
			}
		});
		checkPagerPosition();
	});

	// Page numbers
	$(document).on('click', '.page', function() {
		checkPagerPosition();
	});

	// Handles active state changes for .prev and .next
	function checkPagerPosition() {

		if ($('.pager li:first').hasClass('active')) {
			$('.prev').addClass('disabled');
		} else if ($('.pager li').length === 1) {
			$('.prev, .next').addClass('disabled');
		} else {
			$('.prev').removeClass('disabled');
		}
		// Check if we're on the last page and disable .next if true
		if ($('.pager li:last').hasClass('active')) {
			$('.next').addClass('disabled');
		} else {
			$('.next').removeClass('disabled');
		}
		updateRecordTracker();

	}

	function updateRecordTracker() {
		var pageNumber = $('.pager li.active .page').text(),
        missingPageItems = (pageRecordCount - dataList.visibleItems.length),
        firstPageItemNumber = (pageRecordCount * pageNumber - (pageRecordCount - 1)),
        lastPageItemNumber = (pageRecordCount * pageNumber - missingPageItems);

		// Disable .prev and .next controls if matching records are less than shown entries
		if (dataList.matchingItems.length < pageRecordCount) {
			$('.next, .prev').addClass('disabled');
		}

		// Show no results message in data table if it's empty
		if (dataList.visibleItems.length === 0 || dataList.matchingItems.length === 0) {
			// No Data Available message
			$('.table-body .container .list').append('<li class="tr"><p class="no-record">No Data Available</p></li>');

			// Sets showing value to 0
			$('#page-first-item-number, #page-last-item-number, #record-count-total').text('0');

			// Disables table header sorting
			$('.table-sorter, .th').removeClass('active').addClass('disabled').prop('disabled', true);

			console.log('Sorry there is no data available...');
		} else {
			// Enable table header sorting
			$('.table-sorter, .th').removeClass('disabled').addClass('active').prop('disabled', false);

			// Update records (i.e Showing 1 - 25 of 200)
			// Updates number of first record on current page
			$('#page-first-item-number').text(firstPageItemNumber);

			// Updates number of last record on current page
			$('#page-last-item-number').text(lastPageItemNumber);

			// Updates total count
			$('#record-count-total').text(dataList.matchingItems.length);

			console.log('Number of visible records available is ' + dataList.visibleItems.length);
			console.log('Number of matching records available is ' + dataList.matchingItems.length);
			console.log('Number of missing records on current page is ' + missingPageItems);
			console.log('Number of first record on current page is ' + firstPageItemNumber);
			console.log('Number of last record on current page is ' + lastPageItemNumber);
		}
		console.log('Checked Pager Position! Current page is ' + pageNumber);
		console.log('–––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––');

	}
  
  // GENERAL CLICK EVENTS
	// Dropdown Menu
	$('.dd-trigger').click(function(e) {
		e.preventDefault();

		$('.dropdown').toggleClass('active');

	});
  
	checkPagerPosition();

});