
<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="form-roles" method="post" class="form-horizontal" data-toggle="validator"
      autocomplete="off">
        {{ csrf_field() }} {{ method_field('POST') }}

        <div class="modal-header bg-warning">
          
        {!! Form::button('<span aria-hidden="true"><i class="glyphicon glyphicon-remove-circle"></i></span>'
                              ,['class'=>'close', 'data-dismiss'=>'modal']) !!}
             <h3 class="modal-title"></h3>
        </div>  
        
        <div class="modal-body">
            <input type="hidden" id="id" name="id">

            <div class="form-group">              
              {!! Form::label('name', 'Name', ['class' => 'col-md-3 control-label']) !!}
              <div class="col-md-12">
                <input type="text" id="name" name="name" class="form-control" placeholder="Name" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="slug" class="col-md-3 control-label">Slug</label>
              <div class="col-md-12">
                {!! Form::text('slug', null, ['id' => 'slug', 'class' => 'form-control', 'placeholder' => 'slug', 'autofocus', 'required']) !!}
                <span class="help-block with-errors"></span>
              </div>  
            </div>
            <div class="form-group">
              <label for="description" class="col-md-3 control-label">Description</label>
              <div class="col-md-12">
                <textarea id="description" name="description" class="form-control" cols="5" maxlength="50"></textarea>
                <span class="help-block with-errors"></span>
              </div>  
            </div>
           <! -- aqui se obtienen los special -->
            <div class="form-group">
            <label for="special" class="col-md-3 control-label">Special</label>
            <div class="col-md-12">            
            {!! Form::select('special', ['null' => 'none', 'all-access' => 'All-access', 'no-access' => 'No-access'], '', ['class' => 'form-control', 
                                            'id'=>'special']) !!}
            </div>
            </div> 

            <! -- Permissions -->
            <div class="form-group">
            <label for="permisos" class="col-md-3 control-label"> Permissions</label>
            <div class="col-md-12">
            
            <ul class="list-unstyled">

            <div class="from-group">
                        
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            {!! Form::select('permissions[]', $permissions,null, 
                            ['id'=>'permissions', 'class'=>'form-control margin', 
                            'multiple' => 'multiple']) !!}
                        </div>
                    </div>
            </div> 
           <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save" id="bcreate"></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i> Close
                    </button>
           </div>
      </div>
        </div>
      </form>
    </div>  
  </div>
</div>