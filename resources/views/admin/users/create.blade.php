<!-- Modal Users -->
<div class="modal fade" id="modal-form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      
      

      {!! Form::open(array('method'=>'POST','id'=>'form-users','data-toggle'=>'validator', 
                                'role'=>'form','autocomplete'=>'off' )) !!}
           {{ method_field('POST') }}

        <!-- Header Modal -->  
        <div class="modal-header bg-warning">
            {!! Form::button('<span aria-hidden="true"><i class="glyphicon glyphicon-remove-circle"></i></span>'
                              ,['class'=>'close', 'data-dismiss'=>'modal']) !!}
            <h3 class="modal-title"></h3>
             
        </div> 
      
        <!-- Body Modal-->
        <div class="modal-body">
            <input type="hidden" id="id" name="id"> 
                    <!-- Name -->
                    <div class="from-group">
                        {!! Form::label('name', 'Name') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-user"></i>
                            </span>
                            {!! Form::text('name',null, ['class'=>'form-control',
                                                         'title'=>'Nombre del usuario',
                                                         'placeholder' => 'Name',
                                                         'id'=>'name',
                                                         'autofocus required']) !!}
                        </div>
                    </div>
                    <!-- /Name -->
                    <!-- Email -->
                    <div class="from-group">
                        {!! Form::label('email', 'Email') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            {!! Form::text('email',null, ['class'=>'form-control',
                                                         'title'=>'Email del usuario',
                                                         'placeholder' => 'Email',
                                                         'id'=>'email',
                                                         'autofocus required']) !!}
                        </div>
                    </div>
                    <!-- /Email -->
                    <!-- Password -->
                    <div class="from-group">
                        {!! Form::label('password', 'Password') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-key"></i>
                            </span>
                            {!! Form::password('password',['class' => 'form-control',
                                                           'id'=>'password',
                                                           'title'=>'Contraseña del usuario',
                                                           'placeholder'=>'Password',
                                                           'min'=>'6',
                                                           'max'=>'12',
                                                           'autofocus required']) !!}
                                                           
                        </div>
                        <p><small id="Help" class="form-text text-muted"></small></p>
                    </div>
                    <!-- /Password -->
                    <!-- Password -->
                    <div class="from-group">
                        {!! Form::label('password1', 'Confirmed Password') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-key"></i>
                            </span>
                            {!! Form::password('password1',['class' => 'form-control',
                                                           'id'=>'password1',
                                                           'title'=>'Contraseña del usuario',
                                                           'placeholder'=>'Confirmed Password',
                                                           'min'=>'6',
                                                           'max'=>'12',
                                                           'autofocus required']) !!}
                        </div>
                    </div>
                    <!-- /Password -->
                    <!-- Roles -->
                    <div class="from-group">
                        {!! Form::label('roles', 'Roles') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-address-card"></i>
                            </span>
                            {!! Form::select('roles[]', $roles,null, 
                            ['id'=>'roles', 'class'=>'form-control margin', 
                            'multiple' => 'multiple']) !!}
                        </div>
                    </div>
                    <!-- /Roles -->
                    <!-- Speciality -->
                    <div class="from-group">
                        {!! Form::label('speciality', 'Speciality') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            {!! Form::select('speciality[]', $speciality,null, 
                            ['id'=>'speciality', 'class'=>'form-control margin', 
                            'multiple' => 'multiple']) !!}
                        </div>
                    </div>
                    <!-- /Speciality -->
            
        </div>

        <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-save" id="bcreate"></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-times-circle"></i> Close
                </button>
        </div>
        {!! Form::close() !!}
    </div> 
        
  </div>
</div>