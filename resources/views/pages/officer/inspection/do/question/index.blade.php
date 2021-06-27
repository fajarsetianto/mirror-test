@extends('layouts.officer.full')

@section('site-title','Form Instrument Monitoring dan Evaluasi')
@push('css-top')
<style>
.border-top-success {
    border-top: 15px solid #26a69a;
}
.button {
    min-width: 200px;
    max-width: 200px;
}
</style>
@endpush
@push('scripts-top')
<script src="{{asset('assets/global/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/global/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
<script src="{{asset('assets/global/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('assets/global/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets/global/js/demo_pages/form_checkboxes_radios.js')}}"></script>
<script src="{{asset('assets/global/js/demo_pages/form_inputs.js')}}"></script>
<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
<script>
	let formData = new FormData()
	let countQuestionRespondent = [];
	let countQuestionOfficer = [];
	let numberRespodent = 1;
	let numberOfficer = 1;
	let arrOfferIdOfficer = [];

	$(document).ready(function(){
	});
	
	save = () => {
		let csrf_token = "{{csrf_token()}}"
		formData.delete('_token')
		formData.append('_token', csrf_token)
		$(`.input`).serializeArray().forEach(function(elem){
			formData.delete(elem.name)
			formData.append(elem.name, elem.value)
		})
		$.ajax({
			url: '{{$url}}',
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				new PNotify({
					title: data.title,
					text: data.msg,
					addclass: 'bg-success border-success',
				});

			},
			error: function (data) {
				if(data.status == 422){
					new PNotify({
						title: data.responseJSON.message,
						text: 'please check your input',
						addclass: 'bg-danger border-danger',
					});
				}else{
					new PNotify({
						title: data.statusText,
						text: data.responseJSON.message,
						addclass: 'bg-danger border-danger',
					});
				}

			}
		})
	}
	
	submit = () => {
		let csrf_token = "{{csrf_token()}}"
		formData.delete('_token')
		formData.append('_token', csrf_token)
		$(`.input`).serializeArray().forEach(function(elem){
			formData.delete(elem.name)
			formData.append(elem.name, elem.value)
		})
		$.ajax({
			url: '{{$submit}}',
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				new PNotify({
					title: data.title,
					text: data.msg,
					addclass: 'bg-success border-success',
				});

			},
			error: function (data) {
				if(data.status == 422){
					new PNotify({
						title: data.responseJSON.message,
						text: 'please check your input',
						addclass: 'bg-danger border-danger',
					});
				}else{
					new PNotify({
						title: data.statusText,
						text: data.responseJSON.message,
						addclass: 'bg-danger border-danger',
					});
				}

			}
		})
	}

	questionRespondent = (id, typeClick, questionName, option, answer) => {
		let tempDataOptionResponden = ''
		let typeRespoden = ''
		let uniqId = (new Date()).getTime()
		let checked = ''
		let nameAnswer = ''
		let offerId = ''
		let fileName = ''
		if(countQuestionRespondent.indexOf(id) !== -1){
			return
		}
		countQuestionRespondent.push(id)

		if(option != null){
			dataOption = JSON.parse(option.replace(/&quot;/g, '\"').replace(/\t/g, '\\t'))
		}
		
		if(answer != 'null'){
			dataAnswer 	= JSON.parse(answer.replace(/&quot;/g, '\"').replace(/\t/g, '\\t'))
			nameAnswer 	= dataAnswer.answer
			offerId 	= dataAnswer.offered_answer_id
			fileName 	= typeof nameAnswer.split('-')[2] != undefined ? nameAnswer.split('-')[2] : ''
		}
		
		let row = numberRespodent - 1
		if(typeClick == 'singkat'){
			questionType = 'Singkat'
			
			typeRespoden = `
				<div class="form-group alpaca-field alpaca-field-text alpaca-optional alpaca-autocomplete alpaca-edit alpaca-top alpaca-field-valid" data-alpaca-field-id="alpaca5" data-alpaca-field-path="/" data-alpaca-field-name="">
					<label class="pt-2 control-label alpaca-control-label">Jawaban</label>
					<input type="text" disabled class="alpaca-control form-control" value="${nameAnswer}" placeholder="Jawaban ${questionType}"  autocomplete="off">
				</div>
			`
		} else if (typeClick == 'paraghraf'){
			questionType = 'Paraghraf'

			typeRespoden = `
				<div class="form-group alpaca-field alpaca-field-text alpaca-optional alpaca-autocomplete alpaca-edit alpaca-top alpaca-field-valid" data-alpaca-field-id="alpaca5" data-alpaca-field-path="/" data-alpaca-field-name="">
					<label class="pt-2 control-label alpaca-control-label">Jawaban</label>
					<textarea rows="5" disabled cols="5" class="form-control" placeholder="Jawaban ${questionType}">${nameAnswer}</textarea>
				</div>
			`
		} else if (typeClick == 'pilihan ganda'){
			questionType = 'Ganda'

			dataOption.forEach((element, key) => {
				checked = (offerId == element.id) ? 'checked' : ''
				tempDataOptionResponden += `
				<div class="form-check">
					<label class="form-check-label">
						<input type="radio" class="form-control form-check-input-styled" ${checked} disabled data-fouc>
						${element.value}
					</label>
				</div>
				`
			});

			typeRespoden = `
				<div class="form-group">
					<label class="d-block">Opsi Jawaban</label>
					${tempDataOptionResponden}
				</div>
			`
			
		} else if (typeClick == 'kotak' || typeClick == 'kotak centang'){
			questionType = 'Kotak Centang'
			
			dataOption.forEach((element,key) => {
				checked = (offerId == element.id) ? 'checked' : ''
				tempDataOptionResponden += `
				<div class="form-check">
					<label class="form-check-label">
						<input type="checkbox" ${checked} class="form-control form-check-input-styled" disabled data-fouc>
						${element.value}
					</label>
				</div>
				`
			});

			typeRespoden = `
				<div class="form-group">
					<label class="d-block">Opsi Jawaban</label>
					${tempDataOptionResponden}
				</div>
			`
		} else if (typeClick == 'dropdown') {
			questionType = 'Dropdown'
			icon = 'icon-circle-down2'

			dataOption.forEach(element => {
				checked = (offerId == element.id) ? 'selected' : ''
				tempDataOptionResponden += `
					<option ${checked} value="${element.value}">${element.value}</option>
				`
			});

			typeRespoden = `
				<div class="form-group">
					<label class="d-block">Opsi Jawaban</label>
					<select data-placeholder="Select option" disabled class="form-control form-control-select2">
						<option>Select your option</option>
						${tempDataOptionResponden}
					</select>
				</div>
			`

		} else if (typeClick == 'file-upload' || typeClick == 'file upload'){
			questionType = 'File Upload'
			typeRespoden = `
				<div class="form-group alpaca-field alpaca-field-text alpaca-optional alpaca-autocomplete alpaca-edit alpaca-top alpaca-field-valid" data-alpaca-field-id="alpaca5" data-alpaca-field-path="/" data-alpaca-field-name="">
					<label class="pt-2 control-label d-block alpaca-control-label">Berkas File Upload</label>
					<div tabindex="500" class="btn btn-light text-left text-primary btn-file">
						<i class="icon-upload4 mr-2"></i>
						<span class="hidden-xs">File Upload</span>
						<input type="file" class="file-input" disabled data-fouc>
					</div>
					<span class='ml-1 label label-info'>
						<a target="_blank" href="{{route('officer.monev.inspection.do.question.show',[$officerTarget->id,$item->id])}}?file=${fileName}&type=respondent">${fileName}</a>
					</span>
				</div>
			`
		}

		$(`#question-content`).append(`
			<div class="card card-body" id="card-${row}">
				<div class="row" id="row-${row}">
					<div class="col-md-6">
						<div class="card border-left-teal">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<p class="text-secondary">Responden</p>
									</div>
									<div class="col-lg-1">
										<span class="question-number">${numberRespodent}</span>
									</div>
									<div class="col-lg-11">
										<label>Pertanyaan - ${questionType}</label>
										<input class="alpaca-control form-control flex-1 mr-3" readonly value="${questionName}" placeholder="Pertanyaan - ${questionType}">
										${typeRespoden}
									</div>
								</div>
								<div id="field-other" class="row"></div>

							</div>
						</div>
					</div>
				</div>

			</div>
		`)
		numberRespodent++
	}

	checkboxHandling = (id) => {
		$(`#checkbox-${numberOfficer-1}-${id}`).prop('checked', true);
	}

	questionOfficer = (id=null, typeClick, questionName, option, answer) => {
		let typeOfficer = ''
		let tempDataOptionOfficer = ''
		let uniqId = (new Date()).getTime()
		let checkedOfficer = ''
		let nameAnswerOfficer = ''
		let offerIdOfficer = ''
		let discrepancy = ''
		let fileNameOfficer = ''

		if(answer != 'null'){
			dataAnswerOfficer	= JSON.parse(answer.replace(/&quot;/g, '\"').replace(/\t/g, '\\t'))
			nameAnswerOfficer 	= dataAnswerOfficer.answer
			discrepancy 		= dataAnswerOfficer.discrepancy
			offerIdOfficer 		= dataAnswerOfficer.offered_answer_id
			fileNameOfficer 	= typeof nameAnswerOfficer.split('-')[2] != undefined ? nameAnswerOfficer.split('-')[2] : ''
		}

		if(countQuestionOfficer.indexOf(id) !== -1 && id != null){
			if(typeClick == 'kotak centang') checkboxHandling(offerIdOfficer)
			return
		}

		countQuestionOfficer.push(id)

		if(option != null){
			dataOption = JSON.parse(option.replace(/&quot;/g, '\"').replace(/\t/g, '\\t'))
		}
		
	

		let row = numberOfficer - 1
		if(typeClick == 'singkat'){
			questionType = 'Singkat'
			typeOfficer = `
				<div class="form-group alpaca-field alpaca-field-text alpaca-optional alpaca-autocomplete alpaca-edit alpaca-top alpaca-field-valid" data-alpaca-field-id="alpaca5" data-alpaca-field-path="/" data-alpaca-field-name="">
					<label class="pt-2 control-label alpaca-control-label">Jawaban</label>
					<input type="text" class="alpaca-control form-control input" name="answer_${row}" value="${nameAnswerOfficer}" placeholder="Jawaban ${questionType}"  autocomplete="off">
				</div>
			`
		} else if (typeClick == 'paraghraf'){
			questionType = 'Paraghraf'
			typeOfficer = `
				<div class="form-group alpaca-field alpaca-field-text alpaca-optional alpaca-autocomplete alpaca-edit alpaca-top alpaca-field-valid" data-alpaca-field-id="alpaca5" data-alpaca-field-path="/" data-alpaca-field-name="">
					<label class="pt-2 control-label alpaca-control-label">Jawaban</label>
					<textarea rows="5" cols="5" name="answer_${row}" value="${nameAnswerOfficer}" class="form-control input" placeholder="Jawaban ${questionType}">${nameAnswerOfficer}</textarea>
				</div>
			`
		} else if (typeClick == 'pilihan ganda'){
			questionType = 'Ganda'

			dataOption.forEach((element, key) => {
				checkedOfficer = (offerIdOfficer == element.id) ? 'checked' : ''
				tempDataOptionOfficer += `
				<div class="form-check">
					<label class="form-check-label">
						<input type="radio" ${checkedOfficer} class="form-control form-check-input-styled input" value="${element.value}__${element.id}" name="answer_option_${row}" data-fouc>
						${element.value}
					</label>
				</div>
				`
			});

			typeOfficer = `
				<div class="form-group">
					<label class="d-block">Opsi Jawaban</label>
					${tempDataOptionOfficer}
				</div>
			`
			
		} else if (typeClick == 'kotak' || typeClick == 'kotak centang'){
			questionType = 'Kotak Centang'
			dataOption.forEach((element,key) => {
				checkedOfficer = (offerIdOfficer == element.id) ? 'checked' : ''
				tempDataOptionOfficer += `
				<div class="form-check">
					<label class="form-check-label">
						<input id="checkbox-${numberOfficer}-${element.id}" type="checkbox" ${checkedOfficer} name="answer_option_${row}_${key}" value="${element.value}__${element.id}" class="form-control form-check-input-styled input" data-fouc>
						${element.value}
					</label>
				</div>
				`
			});

			typeOfficer = `
				<div class="form-group">
					<label class="d-block">Opsi Jawaban</label>
					${tempDataOptionOfficer}
				</div>
			`
		} else if (typeClick == 'dropdown') {
			questionType = 'Dropdown'
			icon = 'icon-circle-down2'

			dataOption.forEach(element => {
				checkedOfficer = (offerIdOfficer == element.id) ? 'selected' : ''
				tempDataOptionOfficer += `
					<option ${checkedOfficer} value="${element.value}__${element.id}">${element.value}</option>
				`
			});

			typeOfficer = `
				<div class="form-group">
					<label class="d-block">Opsi Jawaban</label>
					<select data-placeholder="Select option" name="answer_option_${row}"  class="form-control form-control-select2 input">
						<option>Select your option</option>
						${tempDataOptionOfficer}
					</select>
				</div>
			`

		} else if (typeClick == 'file-upload' || typeClick == 'file upload'){
			questionType = 'File Upload'
			typeOfficer = `
				<div class="form-group alpaca-field alpaca-field-text alpaca-optional alpaca-autocomplete alpaca-edit alpaca-top alpaca-field-valid" data-alpaca-field-id="alpaca5" data-alpaca-field-path="/" data-alpaca-field-name="">
					<label class="pt-2 control-label d-block alpaca-control-label">Berkas File Upload</label>
					<div tabindex="500" class="btn btn-light text-left text-primary btn-file">
						<i class="icon-upload4 mr-2"></i>
						<span class="hidden-xs">File Upload</span>
						<input type="file" class="file-input" id="files-${row}" name="file_${row}" onchange="upload(${row},$(this).val())" data-show-caption="true" data-show-upload="true" data-fouc>
					</div>
					<span class='ml-1 label label-info' id="upload-file-info-${row}">
						<a target="_blank" href="{{route('officer.monev.inspection.do.question.show',[$officerTarget->id,$item->id])}}?file=${fileNameOfficer}&type=officer">${fileNameOfficer}</a>
					</span>
				</div>
			`
		}

		$(`#row-${row}`).append(`
			<div class="col-md-6">
				<div class="card border-left-teal">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12">
								<p class="text-secondary">Petugas Monitoring dan Evaluasi</p>
							</div>
							<div class="col-lg-1">
								<span class="question-number">${numberOfficer}</span>
							</div>
							<div class="col-lg-11">
								<label>Pertanyaan - ${questionType}</label>
								<input class="alpaca-control form-control flex-1 mr-3" readonly value="${questionName}" placeholder="Pertanyaan - ${questionType}">
								${typeOfficer}
							</div>
						</div>
						<div id="field-other" class="row"></div>

					</div>
				</div>
			</div>
		`)
		$(`#card-${row}`).append(`
			<div class="form-group">
				<label for="">Perbedaan</label>
				<textarea rows="3" name="discrepancy_${row}" cols="3" class="form-control input" id="discrepancy" placeholder="Perbedaan">${discrepancy}</textarea>
			</div>
		`)

		numberOfficer++
	}
	

	upload = (numberOfficer,name) => {
		$(`#upload-file-info-${numberOfficer}`).html(name.split('\\').pop())
		let file = $(`#files-${numberOfficer}`).prop('files')[0]
		formData.delete(`file_${numberOfficer}`)
		formData.append(`file_${numberOfficer}`, file)
	}
</script>
@endpush

@section('page-header')
<div class="page-header page-header-light">
    <div class="page-header-content">
        <div class="page-title d-flex">
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">
				{{$officerTarget->target->form->name}} - {{$item->name}}
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements border-top-0 bg-white pl-4 pt-0">
            <div class="d-flex">

                <button href="#" onclick="save()" class="mr-3 btn bg-indigo-400 mx-y button"><i class="mi-description"></i>
                    <span>Simpan Sebagai Draft</span>
				</button>
                <button href="#" onclick="submit()" class="btn btn-primary button"><i class="mi-assignment"></i> <span>Kirim</span></button>
            </div>
        </div>
    </div>
</div>
{{-- {{ Breadcrumbs::render('responden.home.form',$form) }} --}}
@endsection
@section('content')
<div class="content">

    <div class="card border-top-success">
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <div class="instrument-header d-flex">
                        <h4><span class="font-weight-semibold">{{$item->name}}</span></h4>
                    </div>
                    <div class="instrument-description">
                        <p class="text-secondary">{{$item->description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id="question-content"></div>
	@foreach($officerTarget->target->respondent->answers()->byInstrumentId($item->id)->get() as $key => $row)
		<script>questionRespondent('{{strtolower($row->question->id)}}','{{strtolower($row->question->questionType->name)}}', '{{$row->question->content}}', '{!!json_encode($row->question->offeredAnswer)!!}', '{!! json_encode($row) !!}')</script>
	@endforeach
	@if(count($officerTarget->answers()->get()) < 1)
		@foreach($item->questions()->get() as $key => $row)
			<script>questionOfficer('{{strtolower($row->id)}}','{{strtolower($row->questionType->name)}}', '{{$row->content}}', '{{json_encode($row->offeredAnswer)}}', '{{json_encode($row->officerAnswerOfficer)}}',)</script>
		@endforeach
	@else
		@foreach($officerTarget->answers()->byInstrumentId($item->id)->get() as $key => $row)
			<script>questionOfficer('{{strtolower($row->question->id)}}','{{strtolower($row->question->questionType->name)}}', '{{$row->question->content}}', '{!!json_encode($row->question->offeredAnswer)!!}', '{!!json_encode($row)!!}')</script>
		@endforeach
	@endif
	
</div>


@endsection