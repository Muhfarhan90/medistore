@props(['label' => '', 'name' => '', 'value' => '', 'placeholder' => '', 'type' => 'text', 'disabled' => false])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" {{$disabled ? 'disabled' : ''}}
        class="form-control form-control-user" id="{{ $name }}" aria-describedby="emailHelp"
        placeholder="{{ $placeholder }}">
</div>
