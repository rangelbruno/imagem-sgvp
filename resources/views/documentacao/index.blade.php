<x-layouts.app title="Documentação" namepage="Documentação">
    <!-- ============================================================== -->
    <!-- Start Page STYLES here -->
    <!-- ============================================================== -->
    @push('styles')
        <link href="{{ url('assets/css/elements/custom-tree_view.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <!-- ============================================================== -->
    <!-- Start CONTENT here -->
    <!-- ============================================================== -->
    <div class="row layout-top-spacing">

        <!-- ============================================================== -->
        <!-- Start CHAMADA PARA API here -->
        <!-- ============================================================== -->
        @include('documentacao.includes.api')

    </div>
    <!-- ============================================================== -->
    <!-- Start SCRIPTS here -->
    <!-- ============================================================== -->
    @push('scripts')
        <script src="{{ url('assets/plugins/treeview/custom-jstree.js') }}"></script>
        <script src="{{ url('assets/js/scrollspyNav.js') }}"></script>
        <script src="{{ url('assets/plugins/highlight/highlight.pack.js') }}"></script>
    @endpush
</x-layouts.app>
