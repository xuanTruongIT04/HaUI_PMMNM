<?php

namespace App\Util;

use Illuminate\Http\Request;

class Pagination
{
    private ?string $keyword;

    private ?int $page;

    private ?int $pageSize;

    private ?string $sortBy;

    private ?string $sortType;

    private ?int $recordCount;

    private ?int $displayRecord;

    public function getDisplayRecord(): ?int
    {
        return $this->displayRecord;
    }

    public function setDisplayRecord(?int $displayRecord): void
    {
        $this->displayRecord = $displayRecord;
    }

    public function getRecordCount(): ?int
    {
        return $this->recordCount;
    }

    public function setRecordCount(?int $recordCount): void
    {
        $this->recordCount = $recordCount;
    }

    public function __construct(Request $request)
    {
        $this->keyword = $request->query(config('paginate.KEYWORD'))
            ? $request->query(config('paginate.KEYWORD'))
            : config('paginate.STRING_EMPTY');

        $this->page = $request->query(config('paginate.PAGE_NUM')) && is_numeric(intval($request->query(config('paginate.PAGE_NUM'))))
            ? intval($request->query(config('paginate.PAGE_NUM')))
            : config('paginate.DEFAULT_PAGE_NUM');

        $this->pageSize = $request->query(config('paginate.PAGE_SIZE')) && is_numeric(intval($request->query(config('paginate.PAGE_SIZE'))))
            ? intval($request->query(config('paginate.PAGE_SIZE')))
            : config('paginate.DEFAULT_PAGE_SIZE');

        $this->sortBy = $request->query(config('paginate.SORT_BY'))
            ? $request->query(config('paginate.SORT_BY'))
            : config('paginate.DEFAULT_SORT_BY');

        $this->sortType = $request->query(config('paginate.SORT_TYPE'))
            ? $request->query(config('paginate.SORT_TYPE'))
            : config('paginate.DEFAULT_SORT_TYPE');
    }

    public static function calculateOffset(int $page, int $pageSize): float|int
    {
        $offset = 0;
        if ($page != 0) {
            $offset += ($page - 1) * $pageSize;
        }

        return $offset;
    }

    public function getKeyWord()
    {
        return $this->keyword;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function getSortBy()
    {
        return $this->sortBy;
    }

    public function getSortType()
    {
        return $this->sortType;
    }
}
