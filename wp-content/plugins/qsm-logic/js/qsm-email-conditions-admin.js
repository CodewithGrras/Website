jQuery(function ($) {

	jQuery(document).on('change', '.email-condition-category', function (event) {
		let container= jQuery(this).parents('.email-condition');
		let conditionOperator = container.find('.email-condition-operator');
		let answer_fields = container.find('.condition-question-value');
		if ('question' == jQuery(this).val()) {
			container.find('.email-extra-condition-category-container').hide();
			container.find('.email-condition-criteria-container').hide();
			container.find('.condition-default-value-container').hide();
			container.find('.email-condition-operator-container').find('label').text(qsm_admin_messages.question);
			container.find('.email-condition-operator-container').show();
			conditionOperator.find('option').prop("selected", false).hide();
			conditionOperator.find('option.question_operator:first').prop("selected", true);
			conditionOperator.find('option.question_operator').show();
			let qid = conditionOperator.val();
			answer_fields.find('option').prop("selected", false).hide();
			answer_fields.find('option[data-qid="' + qid + '"]').show();
			answer_fields.closest('.condition-question-value-container').show();
			answer_fields.val(answer_fields.find('option[data-qid="' + qid + '"]').first().val()).trigger('change');
		} else {
			answer_fields.closest('.condition-question-value-container').hide();
		}
	});
	jQuery(document).on('change', '.email-condition-operator', function (event) {
		var $parent = jQuery(this).parents('.email-condition');
		var category = $parent.find('.email-condition-category').val();
		$parent.find('.condition-question-value-container').hide();
		if (category == 'question') {
			var qid = jQuery(this).val();
			var $valueField = $parent.find('.condition-question-value');
			$valueField.find('option').hide();
			$valueField.find('option[data-qid="' + qid + '"]').show();
			$valueField.closest('.condition-question-value-container').show();
			$valueField.val($valueField.find('option[data-qid="' + qid + '"]').first().val()).trigger('change');
		}
	});
	jQuery(document).on('change', '.condition-question-value', function (event) {
		jQuery(this).parents('.email-condition').find('.condition-default-value').val(jQuery(this).val());
	});

	jQuery(document).on('qsm_after_add_email_condition', function (event, page, category, extra_category, criteria, operator, value) {
        jQuery(page).find('.email-condition').each(function () {
			let container= jQuery(this);
			let conditionOperator = container.find('.email-condition-operator');
			let answer_fields = container.find('.condition-question-value');
			if ( 'question' == container.find('.email-condition-category').val() ) {
				container.find('.email-extra-condition-category-container').hide();
				container.find('.email-condition-criteria-container').hide();
				container.find('.condition-default-value-container').hide();
				container.find('.email-condition-operator-container').find('label').text(qsm_admin_messages.question);
				container.find('.email-condition-operator-container').show();
				conditionOperator.find('option').hide();
				conditionOperator.find('option.question_operator').show();
				let qid = conditionOperator.val();
				answer_fields.closest('.condition-question-value-container').show();
				answer_fields.find('option').hide();
				answer_fields.find('option[data-qid="' + qid + '"]').show();
			}
		});
	});
});