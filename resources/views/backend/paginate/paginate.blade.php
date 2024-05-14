@if ($paginator->hasPages()) 
    <nav aria-label="Page navigation example"> 
        <ul class="pagination"> 
            @if ($paginator->onFirstPage()) 

            <li class="paginate_button page-item previous disabled" id="dataTableExample_previous">
                <a href="#" aria-controls="dataTableExample" data-dt-idx="0" tabindex="-1" class="page-link">Previous</a>
            </li>
            @else 

            <li class="paginate_button page-item previous" id="dataTableExample_previous">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link">Previous</a>
            </li> 
            @endif 


    
            @foreach ($elements as $element) 
            @if (is_string($element)) 
            <li class="page-item disabled">{{ $element }}</li> 
            @endif 
    
            @if (is_array($element)) 
            @foreach ($element as $page => $url) 
            @if ($page == $paginator->currentPage()) 
            <li class="page-item active"> 
                <a class="page-link">{{ $page }}</a> 
            </li> 
            @else 
            <li class="page-item"> 
                <a class="page-link" 
                href="{{ $url }}">{{ $page }}</a> 
            </li> 
            @endif 
            @endforeach 
            @endif 
            @endforeach 
    
            @if ($paginator->hasMorePages()) 

            <li class="paginate_button page-item" id="dataTableExample_next">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link">Next</a>
            </li> 
            @else 
            <li class="paginate_button page-item disabled" id="dataTableExample_next">
                <a href="#" rel="next" class="page-link">Next</a>
            </li> 
            @endif 
        </ul> 
    </nav> 
@endif 