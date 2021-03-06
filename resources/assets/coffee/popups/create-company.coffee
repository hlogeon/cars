SelectView = require '../inc/SelectView'
MakesList = require '../create-company/MakesList'

$('#create-company-button').magnificPopup

	type: 'inline'
	closeBtnInside: true


specs = $('#create-company-spec')

do specs.selectBox

name = $ '#create-company-name'

address = $ '#create-company-address'

phone = $ '#create-company-phone'

about = $ '#create-company-about'

logolabel = $ '#create-company-logo-label'

logolabel.css('padding', '10px')
logolabel.css('margin-bottom', '0')

autosize about


class AddLogo

	constructor: (btn, input, container) ->

		self = @

		@btn = $(btn)

		@input = $(input)

		@container = $(container)

		@input.change ->
			self.check @files

		@src = ''

		@btn.click ->
			self.input.click()

	check: (files) =>
		file = files[0]
		if file.type.search('image') is -1
			do @error
		else
			@read file

	error: ->
		alert 'это не картинка'

	append: (src) ->
		@container.html ''
		img = new Image
		img.src = src
		console.log img
		@container.html img

	get: ->
		@src

	read: (file) ->
		src = ''
		r = new FileReader

		r.onloadend = =>
			src = r.result

			@src = src

			@append src

		r.readAsDataURL(file)


logo = new AddLogo '#create-company-logo-btn', 
			'#create-company-logo',
			'#create-company-logo-html'


class SelectType extends Backbone.View

	initialize: ->
		self = @

		do @$el.selectBox

		@$el.change ->
			
			self.trigger 'changed', $(@).val()

	error: ->
		@$el.selectBox('control').blink()

	get: ->
		@$el.val()


class SelectCType extends Backbone.View

	initialize: ->
		self = @

		do @$el.selectBox

		@$el.change ->

			self.trigger 'changed', $(@).val()

	error: ->
		@$el.selectBox('control').blink()

	get: ->
		@$el.val()

types = new SelectType
	el: '#create-company-type'

cType = new SelectCType
	el: '#create-company-ctype'

makes = new MakesList 
	el: '#create-company_makes-models'
	types: types

submit = $ '#create-company-submit'

companySignUp = $ '#company-signup-auth'

signUpCompanyCheck = $ '#sign-up-company-check'

submit.click ->

	result = {}

	if types.get()?
		result.type = parseInt types.get()
	else
		types.error()
		return


	if cType.get()?
		result.cType = parseInt cType.get()
	else
		cType.error()
		return
	# ===================================

	if specs.val()?
		result.spec = parseInt specs.val()
	else
		specs.selectBox('control').blink()
		return

	# ===================================

	result.makesmodels = makes.get()

	# ===================================

	if name.val() is ''
		name.blink()
		return
	else
		result.name = name.val()
	# ===================================

	if address.val() is ''
		address.blink()
		return
	else
		result.address = address.val()
	# ===================================

	if phone.val() is ''
		phone.blink()
		return
	else
		result.phone = phone.val()
	# ===================================

	if about.val() is ''
		about.blink()
		return
	else
		result.about = about.val()

	# ===================================

	if logo.get() isnt ''
		result.logo = logo.get()
	else
		logolabel.blink()
		return

	# ===================================

	url = 'api/company/create'

	if companySignUp.length
		if signUpCompanyCheck.prop('checked') isnt true
			return

		url = 'api/company/create-signup'

		email = companySignUp.find '.company-signup-email'
		pass = companySignUp.find '.company-signup-pass'

		if email.val() is ''
			email.blink()
			return
		else
			result.email = email.val()

		if pass.val() is ''
			pass.blink()
			return
		else
			result.pass = pass.val()

		pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i

		if not pattern.test email.val()
			email.blink()
			return

	$(@).preload('start')

	$.ajax "#{$('body').data('home')}/#{url}",
			headers:
				'X-CSRF-TOKEN' : $('body').data 'csrf'
			method: 'POST'
			data: result
		.done (response) =>

			console.log response

			$(@).preload('stop')

			if companySignUp.length

				if response.search('http') isnt -1
					location.href = response
				else
					$.magnificPopup.instance.close()
					$.alert 'Пользователь с таким логином уже существует.'


			else

				setTimeout ->
					$.magnificPopup.instance.close()
					$.alert 'Ваша компания добавлена и ожидает проверки.'
				, 1000