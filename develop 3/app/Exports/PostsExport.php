<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $posts;

    public function __construct(Collection $posts)
    {
        $this->posts = $posts;
    }

    public function collection()
    {
        // Transform your $this->posts collection as needed
        return $this->posts;
    }
}
