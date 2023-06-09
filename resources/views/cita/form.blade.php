@php
    $Estado = ['Atendida','Pendiente'];
@endphp

@if (count($errors) > 0)

    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

@section('css')
    <!-- Latest compiled and minified CSS -->
@endsection

<div class="block mx-auto my-12 p-8 bg-white w-1/3 border border-gray-200 rounded-lg shadow-lg col-8">

    <center>
        <h1 style="color: black">{{ $modo }} Cita</h1>
    </center>

    <br>
    <br>

    <div class="form-group">
        {{ Form::label('Cliente') }}
        {{ Form::select('cliente_id', $clientes, $cita->cliente_id, [
            'class' => 'form-control' . ($errors->has('cliente_id') ? ' is-invalid' : ''),
            'placeholder' => 'Ej:Carlos',
        ]) }}
        {!! $errors->first('cliente_id', '<div class="invalid-feedback">:message</div>') !!}
        <p style="color: gray;">*Campo Obligatorio</p>
    </div>


    <div class="form-gropu">
        {{ Form::label('Barbero') }}
        {{ Form::select('empleado_id', $empleados, $cita->empleado_id, [
            'class' => 'form-control' . ($errors->has('empleado_id') ? ' is-invalid' : ''),
            'placeholder' => 'Ej:Francisco',
        ]) }}
        {!! $errors->first('empleado_id', '<div class="invalid-feedback">:message</div>') !!}
        <p style="color: gray;">*Campo Obligatorio</p>
    </div>

    <div class="form-group">
        <label for="Servicio">Servicio</label>
        <select class="js-example-basic-multiple form-control select2" name="servicios[]" id="servicios[]"
            multiple="multiple">
            <option hidden disabled selected value="0">Corte</option>
            @foreach ($servicios as $index => $servicio)
                @if (Route::is('cita.create'))
                    <option value="{{ $servicio['id'] }}">
                        {{ $servicio['Descripcion'] . ' ' . $servicio['Costo'] }}
                    </option>
                @else
                    @foreach ($cita->servicios as $citaServicio)
                        <option value="{{ $servicio['id'] }}"
                            {{ $servicio['id'] === $citaServicio['id'] ? 'selected' : '' }}>
                            {{ $servicio['Descripcion'] . ' ' . $servicio['Costo'] }}
                        </option>
                    @endforeach
                @endif
            @endforeach
        </select>
        <p style="color: gray">*Campo Obligatorio</p>
    </div>

    <div class="form-gropu">
        <label for="Fecha" placeholder="dd/mm/aaaa"> Fecha </label>
        <input type="date" class="form-control" name="Fecha"
            value="{{ isset($cita->Fecha) ? $cita->Fecha : old('Fecha') }}" id="Fecha" />
        <p style="color: gray;">*Campo Obligatorio</p>
    </div>

    <div class="form-gropu">
        <label for="Hora"> Hora </label>
        <input type="time" class="form-control" name="Hora"
            value="{{ isset($cita->Hora) ? $cita->Hora : old('Hora') }}" id="Hora" />
        <p style="color: gray;">*Campo Obligatorio</p>
    </div>

    <div class="form-group">
        <label for="Estado de la cita"> Estado de la cita </label>
        <select type="text" class="form-control" name="Estado" id="Estado">

            <option value="0" readonly>Atendida/Pendiente</option>

            @foreach ($Estado as $estado)
                <option {{ $cita->Estado === $estado? 'selected' : '' }}>{{ $estado }}</option>
            @endforeach
        </select>
        <p style="color: gray;">*Campo Obligatorio</p>
    </div>

    <a style="width: 40px; height:40px ;" class="btn btn-primary" href="{{ url('cita/') }}">
        <i class="fa-solid fa-rotate-left" style="position: absolute; margin-left: -7px; margin-top: 5px"></i>
    </a>

    <i class="fa-regular fa-circle-check" style="position: absolute; margin-left: 12px; margin-top: 12px"></i>
    <input style="width: 40px; height:40px " class="btn btn-success" type="submit" value="" />

</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
