@php
    $categories->loadMissing([
        'slugable',
        'activeChildren:id,name,parent_id',
        'activeChildren.slugable',
    ]);

    $categoriesRequest ??= [];
    $activeCategoryId ??= 0;
@endphp

<ul @class(['loading-skeleton' => $categoriesRequest && (! isset($showAllCategories) || $showAllCategories !== false)])>
    @if (! isset($showAllCategories) || $showAllCategories !== false)
        <li class="category-filter show-all-product-categories mb-2 d-none">
            <a class="nav-list__item-link" href="{{ route('public.products') }}" data-id="">
                <span class="cat-menu-close svg-icon">
                    <svg>
                        <use href="#svg-icon-chevron-left" xlink:href="#svg-icon-close"></use>
                    </svg>
                </span>
                <span>{{ __('All categories') }}</span>
            </a>
        </li>
    @endif
    
    @foreach ($categories as $category)
        <li @class([
                'category-filter',
                'opened' => in_array($category->id, $categoriesRequest) && ($activeCategoryId == $category->id || $urlCurrent != $category->url),
            ])>
            <div class="widget-layered-nav-list__item">
                <div class="nav-list__item-title">
                    <a @class([
                            'nav-list__item-link',
                            'active' => $activeCategoryId == $category->id || $urlCurrent == $category->url,
                        ]) href="{{ $category->url }}" data-id="{{ $category->id }}">
                        @if (! $category->parent_id)
                            @if ($category->getMetaData('icon_image', true))
                                <img src="{{ RvMedia::getImageUrl($category->getMetaData('icon_image', true)) }}"
                                    alt="{{ $category->name }}" width="18" height="18">
                            @elseif ($category->getMetaData('icon', true))
                                <i class="{{ $category->getMetaData('icon', true) }}"></i>
                            @endif
                            <span class="ms-1">{!! BaseHelper::clean($category->name) !!}</span>
                        @else
                            <span>{!! BaseHelper::clean($category->name) !!}</span>
                        @endif
                    </a>
                </div>
                @if ($category->activeChildren->count())
                    <span class="cat-menu-close svg-icon">
                        <svg>
                            <use href="#svg-icon-close" xlink:href="#svg-icon-close"></use>
                        </svg>
                    </span>
                @endif
            </div>
            @if ($category->activeChildren->count())
                @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), [
                    'categories' => $category->activeChildren,
                    'showAllCategories' => false,
                ])
            @endif
        </li>
    @endforeach
</ul>
