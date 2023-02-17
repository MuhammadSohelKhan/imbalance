@extends('layouts.app')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-auto">
				<h2 class="page-title"><a href="{{ route('home') }}">
					Dashboard
				</a></h2>
			</div>
		</div>
	</div>

	<div class="row row-deck row-cards">
		<div class="col-sm-6 col-xl-4">
			<div class="card card-sm">
				<a href="#" data-toggle="modal" data-target="#modal-line-operation">
					<div class="card-body d-flex align-items-center">
					<span class="bg-green text-white stamp mr-3"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="9" cy="19" r="2"></circle><circle cx="17" cy="19" r="2"></circle><path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2"></path></svg>
					</span>
						<div class="mr-3 lh-sm">
							<div class="strong">
								Add New Line
							</div>
							<div class="text-muted">Line</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>

	<livewire:line.lines :summary_id="$ctrlSummary->id">

@endsection


@section('scripts')

  <script type="text/javascript">
    var timer;
    var stepsCount = 0;
    var operationsCount = 1;

    window.addEventListener('refreshJSVariables', function () {
    	stepsCount = 0;
    	operationsCount = 1;
      	clearInterval(timer);
    	var clickBtn = document.getElementById('playTimer');

    	if (clickBtn) {
	    	clickBtn.setAttribute('onclick', 'event.preventDefault(); startTimer(this)');
	    	clickBtn.setAttribute('class', 'col-2 offset-5 text-white btn btn-warning');
    	}
    });


    function startTimer(starter) {
      stepsCount++;
      starter.innerHTML = 'Pause';
      starter.setAttribute('onclick', 'event.preventDefault(); pauseTimer(this)');
      elmTimer = document.getElementById('showTimer');
      elmTimer.innerHTML = 0;
      var sec = 1;
      timer = setInterval(() => {
        elmTimer.innerHTML = sec;
        sec++;
      }, 1000);
    }

    function pauseTimer(stopper) {
      clearInterval(timer);
      stopper.innerHTML = 'Reset';
      stopper.setAttribute('onclick', 'event.preventDefault(); resetTimer(this)');
    }

    function resetTimer(resetter) {
      console.log(stepsCount);
      document.getElementById('step'+stepsCount).value = elmTimer.innerHTML;
      elmTimer.innerHTML = '00:00';
      resetter.innerHTML = 'Play';
      if (stepsCount == 5 || stepsCount == 10 || stepsCount == 15 || stepsCount == 20) {
      	operationsCount++;
      	resetter.innerHTML = 'Add '+operationsCount;
      	resetter.setAttribute('class', 'col-2 offset-5 text-white btn btn-danger');
      	resetter.setAttribute('onclick', 'event.preventDefault(); addNewOperation(this,'+operationsCount+')');
      } else if (stepsCount < 25) {
      	resetter.setAttribute('onclick', 'event.preventDefault(); startTimer(this)');
      } else {
      	resetter.style.visibility = 'hidden';
      	elmTimer.innerHTML = 'Limit Reached!';
      	stepsCount = 0;
    	operationsCount = 1;
      }
    }

    function addNewOperation(btnElem, oprCount) {
    	var operationElem = `
    		<div id="operation${oprCount}" class="modal-body">
          	<div class="row">
          		<h3 class="text-muted">Operation-${oprCount}</h3>
          	</div>
          	<div id="stage${oprCount}" class="row offset-1">
              	<div id="stageDiv${oprCount}"></div>
          		<div class="col-2 px-1">
          			<input id="step${stepsCount+1}" name="step${stepsCount+1}" wire:model="step${stepsCount+1}" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step${stepsCount+2}" name="step${stepsCount+2}" wire:model="step${stepsCount+2}" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step${stepsCount+3}" name="step${stepsCount+3}" wire:model="step${stepsCount+3}" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step${stepsCount+4}" name="step${stepsCount+4}" wire:model="step${stepsCount+4}" class="w-100" type="number" required>
          		</div>
          		<div class="col-2 px-1">
          			<input id="step${stepsCount+5}" name="step${stepsCount+5}" wire:model="step${stepsCount+5}" class="w-100" type="number" required>
          		</div>
          	</div>
          </div>
    	`;

    	var prevOprElem = document.getElementById('operation'+(oprCount-1));
    	prevOprElem.insertAdjacentHTML('afterend', operationElem);
      	btnElem.innerHTML = 'Play';
      	btnElem.setAttribute('class', 'col-2 offset-5 text-white btn btn-warning');
      	btnElem.setAttribute('onclick', 'event.preventDefault(); startTimer(this)');
    	console.log(btnElem);
    }
  </script>

    {{-- <script type="text/javascript">
    	window.addEventListener('resetModalForm', function () {
    		document.getElementById('summary-form').reset();
    		const formSpans = document.querySelectorAll("#summary-form div.mb-3 span.text-danger");
    		for (var i = 0; i < formSpans.length; i++) {
    			formSpans[i].innerHTML = '';
    		}
    	})
    </script> --}}
@endsection
