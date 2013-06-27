@extends('layout')

@section('title')File - {{$file}}@stop

@section('content')
    <?php
        // Retrive object from DB
        $db = Query::where('name', $path)->get()->first();

        // Get the Query source
        $source = file_get_contents(base_path() . "/query/" . $file . ".sql");
        $geshi = new GeSHi(trim($source), 'sql');

        // Get the output
        $filename = Execution::getSafeDate($db->last_execution_at) . ".out";
        $output = file_get_contents(base_path() . "/output/" . $file . "/" . $filename);

        // Get the config
        $config = parse_ini_file(base_path() . "/query/" . $file . ".cnf");

        // Get average run
        $runtime = DB::table('executions')->where('query_id', $db->id)->avg('duration');
    ?>
    <h1>{{SourceController::linkedPath($path)}}</h1>

    <h2>Output ({{$db->last_execution_results}})</h2>
    <pre class="txt" style="font-family:monospace;">{{SourceController::cleanWikiCode(trim($output),$config['project'])}}</pre>

    <h2>Information</h2>
    Last run: {{$db->last_execution_at}}<br />
    @if ($config['author'] AND $config['author'] != 'unknown')
        Author: {{$config['author']}}<br />
    @endif
    @if ($config['license'])
        License: {{$config['license']}}<br />
    @endif
    @if ($config['frequency'] == 'default')
        Frequency: daily<br />
    @elseif
        Frequency: {{$config['frequency']}}<br />
    @endif
    @if ($db->times != 1)
        Query ran {{$db->times}} times taking averagely {{$runtime / 1000}} seconds<br />
    @elseif
        Query ran {{$db->times}} time taking {{$runtime / 1000}} seconds<br />
    @endif


    <h2>Query</h2>
    {{$geshi->parse_code()}}

@stop
