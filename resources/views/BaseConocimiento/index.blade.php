@extends('adminlte::page')

@section('title','Base de Conocimiento')

@push('js')
    {!! Html::script('./js/tools/loadingOverlay/loadingoverlay.min.js') !!}
    {!! Html::script('./js/system/method/table.js') !!}
@endpush

@push('css')
    <!-- Estilos para botón flotante -->
    {!! Html::style('./css/button_float.css') !!}
@endpush

@section('content')
	<div class="row">
       <div class="col-md-12">
      
        @if(session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                    @endif
                    
                    @if(count($errors))
                    <div class="alert alert-success">
                        <ul>
			
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
        @endif
        <section class="content-header">
            <h1><i class="fas fa-database"></i> Base de Conocimiento
            
            
            <div class="form-inline pull-right">

                <a href="{{ route('baseConocimiento.solutions') }}" class="btn btn-info"><i class="fas fa-cloud-download-alt"></i> Solutions</a>

                {!! Form::button('<i class="fas fa-plus"></i> Create', 
                            ['class'=>'btn btn-info',
                            'data-toggle' =>'modal',
                            'onclick'=>'addFrom()']) !!}
            

            @can('baseConocimiento.validate')
            <a href="{{ route('baseConocimiento.validate') }}" class="btn btn-primary">Validate <span class="badge badge-pill">{{ $request->count() }}</span></a>
            @endcan
            </div>
            
            <div class="col-md-3 pull-right">
            
            <div class="input-group">
                {!! Form::text('criterio',null,['class'=>'form-control', 'id'=>'criterio','placeholder'=>'Search...']) !!}
                        <span class="input-group-btn">
                {!! Form::button('Search', 
                                ['class'=>'btn btn-primary btn-flat',
                                'onclick'=>'search()']) !!}

                      </span>
                </div>
            </div>
            </h1>
            
        </section>
        <section class="content" id="content-body">
            
        </section>
        </div>
    </div>
@include('BaseConocimiento.modal')
@endsection

@section('js')

<script type="text/javascript">
    var contentBody = $('#content-body');
    var criterio = $('#criterio').val('');
        
    CKEDITOR.config.height= 200;
    CKEDITOR.config.widht='auto';
    CKEDITOR.replace('solution',{toolbar: [ 
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-',] }, 
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] }, 
    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },    
     ]});
        
        function addFrom(){
            $('#modal').modal('show');
            $('#modal-title').text('Create Solution');
            $('#modal-btn-save').text('Create');
            $('#modal-body form')[0].reset();
            $('#category').select2({
            width:'100%'
            });
            $('#tags').tagsinput('removeAll');
            $('#tags').tagsinput({
                maxTags: 5,
            });
            CKEDITOR.instances['solution'].setData('',function(){
            instances.destroy();
            });
        }

        function editFrom(id){
          
          $('#modal').modal('show');
          $('#modal-title').text('Edit Solution');
          $('#modal-btn-save').text('Edit');
          $('input[name=_method]').val('PATCH');
          $('#modal-body form')[0].reset();
          contentBody.LoadingOverlay('show');
          $('#tags').tagsinput('destroy');
          $.ajax({
          url: "{{ url('baseConocimiento/edit') }}" + '/' + id,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
            contentBody.LoadingOverlay('hide', true);
            tags = [];
            $('#id').val(data.base.id);
            $('#category').val(data.base.category_id);
            $('#category').select2({width:'100%'});
            $('#name').val(data.base.name);
            $('#description').val(data.base.description);
            $.each(data.base.tagged, function(i,item){
                tags.push(data.base.tagged[i].tag_slug);                    

            });
            $('#tags').val(tags);
            $('#tags').tagsinput('refresh');
            CKEDITOR.instances['solution'].setData(data.base.solution);
            
          },
          error : function() {
              swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Nothing Data'
              })
          }
        });
        }

        $('.close-modal').click(function(){
            $('#id').val('');
        });
        

        $('#modal-btn-save').click(function(event){
            event.preventDefault();
            idUpdate = $('#id');
            var me = $('#modal-body form');
                if(idUpdate.val().trim().length == 0){
                    url = me.attr('action');
                    method = 'POST';
                }else{
                    url = `update/${idUpdate.val()}`;
                    method = 'PUT'; 
                }
                me.find('.help-block').remove();
                me.find('.form-group').removeClass('has-error');
            
                for (instance in CKEDITOR.instances){
                        CKEDITOR.instances[instance].updateElement();
                        /*CKEDITOR.instances[$('#description')].setData("");*/
                    }
                
            $.ajax({
                url : url,
                method : method,
                data : me.serialize(),
                success: function (response){
                    me.trigger('reset');
                    $('#modal').modal('hide');
                    swal({
                        type : 'success',
                        title : 'Success!',
                        text : 'Data has been saved!'
                    });
                    loadBody();
                },
                error: function (xhr){
                    var  res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function (key, value) {
                            $('#' + key)
                                .closest('.form-group')
                                .addClass('has-error')
                                .append('<span class="help-block"><strong>' + value + '</strong></span>');
                        });
                    }
                }

            })    


        });
        
        $(document).keypress(function(e) {
            if(e.which == 13) {
                search();
            }
        });
        function search(){
            contentBody.LoadingOverlay('show');
            criterio = $('#criterio').val();
            ruta = "{{ url('baseConocimiento/criterio') }}" + '/' + criterio;
            if(criterio != ""){
            $.getJSON(ruta)
            .done(function(data){
                contentBody.LoadingOverlay('hide', true);
                if(!data.error){
                    contentBody.html(data.body);                        
                }else{                    
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "error"
                    });
                }                
            })
            .fail(function() {
                    loadBody();
            });
            }else{
                loadBody();
            }
            
        }


        function loadBody(){
            contentBody.LoadingOverlay('show');
                $.getJSON('{!! route('baseConocimiento.loadBody') !!}')
                .done(function(data){
                    contentBody.LoadingOverlay('hide', true);
                    if(!data.error){
                        contentBody.html(data.body);                        
                    }else{                    
                        swal({
                            title: data.title,
                            text: data.text,
                            icon: "error"
                        });
                    }                
                });
            
            
        }

        

        loadBody();
        $(document).on('click', '.pagination a', function(event){            
            contentBody.LoadingOverlay('show');
            event.preventDefault();
            criterio = $('#criterio').val(); 
            paginador = $(this).attr('href').split('page')[1];
            if(criterio != ""){
                ruta = "{{ url('baseConocimiento/criterio') }}" + '/' + criterio +'?page'+paginador;   
            }else{
                ruta = '{!! route('baseConocimiento.loadBody') !!}'+'?page'+paginador;
            }
            $.getJSON(ruta)
            .done(function(data){
                contentBody.LoadingOverlay('hide', true);
                if(!data.error){
                    contentBody.html(data.body);                    
                }
            })
            .fail(function(jqXHR, textStatus){
                contentBody.LoadingOverlay('hide', true);
                console.log(jqXHR);
            });
        });
</script>
@endsection