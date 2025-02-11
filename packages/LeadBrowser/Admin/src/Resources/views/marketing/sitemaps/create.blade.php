@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.marketing.sitemaps.add-title') }}
@stop

@section('content-wrapper')
    <div class="content">

        <form method="POST" action="{{ route('sitemaps.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('sitemaps.index') }}'"></i>

                        {{ __('admin::app.marketing.sitemaps.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.marketing.sitemaps.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    {!! view_render_event('marketing.sitemaps.create.before') !!}

                    <accordian title="{{ __('admin::app.marketing.sitemaps.general') }}" :active="true">
                        <div slot="body">
                            <div class="form-group" :class="[errors.has('file_name') ? 'has-error' : '']">
                                <label for="file_name" class="required">{{ __('admin::app.marketing.sitemaps.file-name') }}</label>
                                <input v-validate="'required'" class="control" id="file_name" name="file_name" value="{{ old('file_name') }}" data-vv-as="&quot;{{ __('admin::app.marketing.sitemaps.file-name') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('file_name')">@{{ errors.first('file_name') }}</span>
                                <span class="control-info">{{ __('admin::app.marketing.sitemaps.file-name-info') }}</span>
                            </div>

                            <div class="form-group" :class="[errors.has('path') ? 'has-error' : '']">
                                <label for="path" class="required">{{ __('admin::app.marketing.sitemaps.path') }}</label>
                                <input v-validate="'required'" class="control" id="path" name="path" value="{{ old('path') }}" data-vv-as="&quot;{{ __('admin::app.marketing.sitemaps.path') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('path')">@{{ errors.first('path') }}</span>
                                <span class="control-info">{{ __('admin::app.marketing.sitemaps.path-info') }}</span>
                            </div>

                        </div>
                    </accordian>

                    {!! view_render_event('marketing.sitemaps.create.after') !!}

                </div>
            </div>
        </form>
    </div>
@stop