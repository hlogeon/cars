<script id="create-company-model-template" type="text/x-handlebars-template">
	
	<select name="" class="popup_select create-company_select">

		<option value="all" selected class="popup_option">Все модели</option>

		{{#each models}}
			<option value="{{id}}" class="popup_option">
				{{title}}
			</option>	
		{{/each}}

	</select>
	
	<div class="popup_redx popup_redx--left"></div>

</script>
