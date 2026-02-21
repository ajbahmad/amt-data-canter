<!----Breadcrumb Start---->
<div class="card mb-6 shadow-none">
    <div class="card-body p-6">
        <div class="sm:flex items-center justify-between ">
            <h4 class="font-semibold text-xl text-dark dark:text-white">
                {{ $title ?? '' }}
            </h4>
            <ol class="flex items-center" aria-label="Breadcrumb">
                @if(!empty($breadcrumbs))
                    @foreach($breadcrumbs as $index => $breadcrumb)
                        <li class="flex items-center">
                            @if(isset($breadcrumb['url']) && $index < count($breadcrumbs) - 1)
                                <a class="text-sm font-medium" href="{{ $breadcrumb['url'] }}">
                                    {{ $breadcrumb['name'] }}
                                </a>
                            @else
                                <span class="text-sm font-medium" aria-current="page">
                                    {{ $breadcrumb['name'] }}
                                </span>
                            @endif
                        </li>
                        @if($index < count($breadcrumbs) - 1)
                            <li>
                                <div class="h-1 w-1 rounded-full bg-bodytext mx-2.5 flex items-center mt-1"></div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ol>
        </div>
    </div>
</div>
<!----Breadcrumb End---->
