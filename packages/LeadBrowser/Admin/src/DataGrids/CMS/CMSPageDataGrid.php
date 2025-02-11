<?php

namespace LeadBrowser\Admin\DataGrids\CMS;

use Illuminate\Support\Facades\DB;
use LeadBrowser\UI\DataGrid\DataGrid;

class CMSPageDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('cms_pages')
            ->select('cms_pages.id', 'cms_page_translations.page_title', 'cms_page_translations.url_key')
            ->leftJoin('cms_page_translations', function($leftJoin) {
                $leftJoin->on('cms_pages.id', '=', 'cms_page_translations.cms_page_id')
                         ->where('cms_page_translations.locale', app()->getLocale());
            });

        $this->addFilter('id', 'cms_pages.id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'page_title',
            'label'      => trans('admin::app.cms.pages.page-title'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'url_key',
            'label'      => trans('admin::app.datagrid.url'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                return '<a target="_blank" href="/page/' . $row->url_key . '">' . $row->url_key . '</a>';
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'cms.pages.edit',
            'icon'   => 'icon pencil-icon',
        ]);
 
        $this->addAction([
            'title'  => trans('admin::app.datagrid.delete'),
            'method' => 'POST',
            'route'  => 'cms.pages.delete',
            'icon'   => 'icon trash-icon',
        ]);
    } 

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('cms.pages.mass-delete'),
            'method' => 'POST',
        ]);
    }
}
