<?php
/**
 *  app/Traits/ScopeFilter.php
 *
 * Date-Time: 04.06.21
 * Time: 10:05
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeFilter
{

    /**
     * @param  $request
     *
     * @return Builder
     */
    public function filter($request): Builder
    {
        $data = $this->query();
        $filterScopes = $this->getFilterScopes();
        foreach ($this->getActiveFilters($request) as $filter => $value) {
            if (!array_key_exists($filter, $filterScopes)) {
                continue;
            }
            $filterScopeData = $filterScopes[$filter];

            if (false === $filterScopeData['hasParam']) {
                $data->{$value}();
                continue;
            }
            $methodToExecute = $filterScopeData['scopeMethod'];
            $data->{$methodToExecute}($value);
        }

        $sortParams = ['sort' => 'id', 'order' => 'desc'];

        if ($request->filled('sort') && $request->filled('order')) {
            $sortParams = $request->only('sort', 'order');
        }

        return $data->sorted($sortParams);
    }

    /**
     * @param  $request
     *
     * @return array
     */
    public function getActiveFilters($request): array
    {
        $activeFilters = [];
        foreach ($this->getFilterScopes() as $key => $value) {
            if ($request->filled($key)) {
                $activeFilters [$key] = $request->{$key};
            }
        }
        return $activeFilters;
    }

    /**
     * @param $query
     * @param array $sortParams
     *
     * @return mixed
     */
    public function scopeSorted($query, array $sortParams)
    {
        return $query->orderBy($sortParams['sort'], $sortParams['order']);
    }

    /**
     * @param $query
     * @param $id
     *
     * @return mixed
     */
    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }

    /**
     * @param $query
     * @param $name
     *
     * @return mixed
     */
    public function scopeName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    /**
     * @param $query
     * @param $name
     *
     * @return mixed
     */
    public function scopeTitle($query, $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    /**
     * @param $query
     * @param $locale
     *
     * @return mixed
     */
    public function scopeLocale($query, $locale)
    {
        return $query->where('locale', 'like', '%' . $locale . '%');
    }

    /**
     * @param $query
     * @param $status
     *
     * @return mixed
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * @param $query
     * @param $text
     *
     * @return mixed
     */
    public function scopeText($query, $text)
    {
        return $query->where('text', 'like', '%' . $text . '%');
    }

    /**
     * @param $query
     * @param $slug
     *
     * @return mixed
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', 'like', '%' . $slug . '%');
    }

    /**
     * @param $query
     * @param $slug
     *
     * @return mixed
     */
    public function scopeKey($query, $slug)
    {
        return $query->where('key', 'like', '%' . $slug . '%');
    }


    /**
     * @param $query
     * @param $title
     *
     * @return mixed
     */
    public function scopeTitleLanguage($query, $title)
    {
        return $query->whereHas('languages', function ($query) use ($title) {
            return $query->where('title', 'like', '%' . $title . '%');
        });
    }

    /**
     * @param $query
     * @param $value
     *
     * @return mixed
     */
    public function scopeValueLanguage($query, $value)
    {
        return $query->whereHas('languages', function ($query) use ($value) {
            return $query->where('value', 'like', '%' . $value . '%');
        });
    }

    /**
     * @param $query
     * @param $search
     *
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('search', $search);
    }
}