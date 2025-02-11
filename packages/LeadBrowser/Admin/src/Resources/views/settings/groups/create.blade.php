@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.settings.groups.create-title') }}
@stop

@section('content-wrapper')
    <div class="content full-page adjacent-center">
        {!! view_render_event('settings.groups.create.header.before') !!}

        <div class="page-header">
            
            {{ Breadcrumbs::render('settings.groups.create') }}

            <div class="page-title">
                <h1>{{ __('admin::app.settings.groups.create-title') }}</h1>
            </div>
        </div>

        {!! view_render_event('settings.groups.create.header.after') !!}

        <form method="POST" action="{{ route('settings.groups.store') }}" @submit.prevent="onSubmit">
            <div class="page-content">
                <div class="form-container">
                    <div class="panel">
                        <div class="panel-header">
                            {!! view_render_event('settings.groups.create.form_buttons.before') !!}

                            <button type="submit" class="btn btn-primary">
                                {{ __('admin::app.settings.groups.save-btn-title') }}
                            </button>

                            <a href="{{ route('settings.groups.index') }}">
                                {{ __('admin::app.layouts.back') }}
                            </a>

                            {!! view_render_event('settings.groups.create.form_buttons.after') !!}
                        </div>

                        <div class="panel-body">
                            {!! view_render_event('settings.groups.create.form_controls.before') !!}

                            @csrf()
                            
                            <div class="form-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.layouts.name') }}
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="control"
                                    value="{{ old('name') }}"
                                    placeholder="{{ __('admin::app.layouts.name') }}"
                                    v-validate="'required'"
                                    data-vv-as="{{ __('admin::app.layouts.name') }}"
                                />

                                <span class="control-error" v-if="errors.has('name')">
                                    @{{ errors.first('name') }}
                                </span>
                            </div>

                            <div class="form-group" :class="[errors.has('description') ? 'has-error' : '']">
                                <label class="required">
                                    {{ __('admin::app.settings.groups.description') }}
                                </label>

                                <textarea
                                    class="control"
                                    name="description"
                                    placeholder="{{ __('admin::app.settings.groups.description') }}"
                                    v-validate="'required'"
                                    data-vv-as="{{ __('admin::app.settings.groups.description') }}"
                                >{{ old('name') }}</textarea>

                                <span class="control-error" v-if="errors.has('description')">
                                    @{{ errors.first('description') }}
                                </span>
                            </div>

                            {!! view_render_event('settings.groups.create.form_controls.after') !!}
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop