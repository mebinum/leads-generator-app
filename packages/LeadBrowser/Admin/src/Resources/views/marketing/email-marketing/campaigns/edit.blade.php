@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.marketing.campaigns.edit-title') }}
@stop

@section('content-wrapper')
    <div class="content">

        <form method="POST" action="{{ route('campaigns.update', $campaign->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('campaigns.index') }}'"></i>

                        {{ __('admin::app.marketing.campaigns.edit-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.marketing.campaigns.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    {!! view_render_event('marketing.templates.create.before') !!}

                    <accordian title="{{ __('admin::app.marketing.campaigns.general') }}" :active="true">
                        <div slot="body">

                            <div class="form-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('admin::app.marketing.campaigns.name') }}</label>
                                <input v-validate="'required'" class="control" id="name" name="name" value="{{ old('name') ?: $campaign->name }}" data-vv-as="&quot;{{ __('admin::app.marketing.campaigns.name') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="form-group" :class="[errors.has('subject') ? 'has-error' : '']">
                                <label for="subject" class="required">{{ __('admin::app.marketing.campaigns.subject') }}</label>
                                <input v-validate="'required'" class="control" id="subject" name="subject" value="{{ old('subject') ?: $campaign->subject }}" data-vv-as="&quot;{{ __('admin::app.marketing.campaigns.subject') }}&quot;"/>
                                <span class="control-error" v-if="errors.has('subject')">@{{ errors.first('subject') }}</span>
                            </div>

                            <div class="form-group" :class="[errors.has('marketing_event_id') ? 'has-error' : '']">
                                <label for="marketing_event_id" class="required">{{ __('admin::app.marketing.campaigns.event') }}</label>
                                <?php $selectedOption = old('marketing_event_id') ?: $campaign->marketing_event_id ?>
                                <select class="control" v-validate="'required'" id="marketing_event_id" name="marketing_event_id" data-vv-as="&quot;{{ __('admin::app.marketing.campaigns.event') }}&quot;">
                                    @foreach (app('LeadBrowser\Marketing\Repositories\EventRepository')->all() as $event)
                                        <option value="{{ $event->id }}" {{ $selectedOption == $event->id ? 'selected' : '' }}>
                                            {{ $event->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="control-error" v-if="errors.has('marketing_event_id')">@{{ errors.first('marketing_event_id') }}</span>
                            </div>

                            <div class="form-group" :class="[errors.has('marketing_template_id') ? 'has-error' : '']">
                                <label for="marketing_template_id" class="required">{{ __('admin::app.marketing.campaigns.email-template') }}</label>
                                <?php $selectedOption = old('marketing_template_id') ?: $campaign->marketing_template_id ?>
                                <select v-validate="'required'" class="control" id="marketing_template_id" name="marketing_template_id" data-vv-as="&quot;{{ __('admin::app.marketing.campaigns.email-template') }}&quot;">
                                    @foreach (app('LeadBrowser\Marketing\Repositories\TemplateRepository')->all() as $template)
                                        <option value="{{ $template->id }}" {{ $selectedOption == $template->id ? 'selected' : '' }}>
                                            {{ $template->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="control-error" v-if="errors.has('marketing_template_id')">@{{ errors.first('marketing_template_id') }}</span>
                            </div>

                            <div class="form-group" :class="[errors.has('status') ? 'has-error' : '']">
                                <label for="status" class="required">{{ __('admin::app.marketing.campaigns.status') }}</label>
                                <?php $selectedOption = old('status') ?: $campaign->status ?>
                                <select class="control" v-validate="'required'" id="status" name="status" data-vv-as="&quot;{{ __('admin::app.marketing.campaigns.display-mode') }}&quot;">
                                    <option value="0" {{ $selectedOption == 0 ? 'selected' : '' }}>
                                        {{ __('admin::app.marketing.campaigns.inactive') }}
                                    </option>
                                    <option value="1" {{ $selectedOption == 1 ? 'selected' : '' }}>
                                        {{ __('admin::app.marketing.campaigns.active') }}
                                    </option>
                                </select>
                                <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                            </div>

                        </div>
                    </accordian>

                    <accordian title="{{ __('admin::app.marketing.campaigns.audience') }}" :active="true">
                        <div slot="body">

                            <div class="form-group" :class="[errors.has('customer_group_id') ? 'has-error' : '']">
                                <label for="customer_group_id" class="required">{{ __('admin::app.marketing.campaigns.customer-group') }}</label>
                                <?php $selectedOption = old('customer_group_id') ?: $campaign->customer_group_id ?>
                                <select v-validate="'required'" class="control" id="customer_group_id" name="customer_group_id" data-vv-as="&quot;{{ __('admin::app.marketing.campaigns.customer-group') }}&quot;">
                                    @foreach (app('LeadBrowser\Customer\Repositories\CustomerGroupRepository')->all() as $customerGroup)
                                        <option value="{{ $customerGroup->id }}" {{ $selectedOption == $customerGroup->id ? 'selected' : '' }}>
                                            {{ $customerGroup->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="control-error" v-if="errors.has('customer_group_id')">@{{ errors.first('customer_group_id') }}</span>
                            </div>

                        </div>
                    </accordian>

                    {!! view_render_event('marketing.templates.create.after') !!}

                </div>
            </div>
        </form>
    </div>
@stop