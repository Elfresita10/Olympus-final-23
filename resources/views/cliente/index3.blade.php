@extends('layouts.app') @section('content')
    <div class="container">
        @if (Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ Session::get('mensaje') }}
                <button type="buttom" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="block mx-auto my-12 p-8 bg-white w-1/3 border border-gray-200 rounded-lg shadow-lg col-10">

        @section('js')
            <script>
                $(document).ready(function() {
                    $('#clientes').DataTable({
                        language: {
                            "lengthMenu": "Mostrar _MENU_ registros",
                            "zeroRecords": "No se encontraron resultados",
                            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sSearch": "Buscar:",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "sProcessing": "Procesando...",
                        },
                        //para usar los botones   
                        responsive: "true",
                        dom: 'Bfrtilp',
                        buttons: [{
                                extend: 'excelHtml5',
                                text: '<i class="fas fa-file-excel"></i> ',
                                titleAttr: 'Exportar a Excel',
                                className: 'btn btn-success'
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="fas fa-file-pdf"></i> ',
                                titleAttr: 'Exportar a PDF',
                                title: 'Listado de Clientes',
                                messageTop: document.getElementById('hora').innerHTML +=
                                    `${day} de ${meses[month]} de ${year}`,
                                className: 'btn btn-danger'
                            },
                            {
                                extend: 'print',
                                text: '<i class="fa fa-print"></i> ',
                                titleAttr: 'Imprimir',
                                className: 'btn btn-info'
                            },
                        ]
                    });
                });
            </script>
        @endsection

        <center>
            <h3>Clientes</h3>
        </center>

        <a href="{{ url('cliente/create') }}" class="btn btn-success">
            <i style="margin-top: 10px" class="fa-solid fa-user-plus"></i>
        </a>
        <br />
        <br />

        <div class="table-respomsive">
            <table class="table table-striped table-bordered table-hover" id="clientes">
                <thead class="thead-dark">
                    <tr>
                        <th class="thead-dark" scope="col">CI</th>
                        <th class="thead-dark" scope="col">Nombres</th>
                        <th class="thead-dark" scope="col">Apellidos</th>
                        <th class="thead-dark" scope="col">Correo</th>
                        <th class="thead-dark" scope="col">Telefono</th>
                        <th class="thead-dark" scope="col">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td scope="row">{{ $cliente->CI }}</td>

                            <td>{{ $cliente->Nombres }}</td>
                            <td>{{ $cliente->Apellidos }}</td>
                            <td>{{ $cliente->Correo }}</td>
                            <td>{{ $cliente->Telefono }}</td>
                            <td>
                                <a href="{{ url('/cliente/' . $cliente->id . '/edit') }}" class="btn btn-warning"
                                    style="width: 40px; height: 40px">
                                    <i class="fa-solid fa-pen"
                                        style="
                                        position: absolute;
                                        margin-left: -7px;
                                        margin-top: 5px;
                                    "></i>
                                </a>
                                |

                                <form action="{{ url('/cliente/' . $cliente->id) }}" class="d-inline" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <i class="fa-solid fa-trash"
                                        style="
                                        position: absolute;
                                        margin-left: 13px;
                                        margin-top: 11px;
                                    "></i>
                                    <input style="width: 40px; height: 40px" class="btn btn-danger" type="submit"
                                        onclick="return confirm('¿Quieres borrar?')" value="" />
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <style type="text/css">
                .highcharts-figure,
                .highcharts-data-table table {
                    min-width: 310px;
                    max-width: 800px;
                    margin: 1em auto;
                }

                #container {
                    height: 400px;
                }

                .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #ebebeb;
                    margin: 10px auto;
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
                }

                .highcharts-data-table caption {
                    padding: 1em 0;
                    font-size: 1.2em;
                    color: #555;
                }

                .highcharts-data-table th {
                    font-weight: 600;
                    padding: 0.5em;
                }

                .highcharts-data-table td,
                .highcharts-data-table th,
                .highcharts-data-table caption {
                    padding: 0.5em;
                }

                .highcharts-data-table thead tr,
                .highcharts-data-table tr:nth-child(even) {
                    background: #f8f8f8;
                }

                .highcharts-data-table tr:hover {
                    background: #f1f7ff;
                }
            </style>
            </head>

            <body>


                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <p class="highcharts-description">
                        Chart showing browser market shares. Clicking on individual columns
                        brings up more detailed data. This chart makes use of the drilldown
                        feature in Highcharts to easily switch between datasets.
                    </p>
                </figure>



                <script type="text/javascript">
                    // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

                    // Create the chart
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            align: 'left',
                            text: 'Browser market shares. January, 2022'
                        },
                        subtitle: {
                            align: 'left',
                            text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                        },
                        accessibility: {
                            announceNewData: {
                                enabled: true
                            }
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Total percent market share'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.1f}%'
                                }
                            }
                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        },

                        series: [{
                            name: 'Browsers',
                            colorByPoint: true,
                            data: [{
                                    name: 'Chrome',
                                    y: 63.06,
                                    drilldown: 'Chrome'
                                },
                                {
                                    name: 'Safari',
                                    y: 19.84,
                                    drilldown: 'Safari'
                                },
                                {
                                    name: 'Firefox',
                                    y: 4.18,
                                    drilldown: 'Firefox'
                                },
                                {
                                    name: 'Edge',
                                    y: 4.12,
                                    drilldown: 'Edge'
                                },
                                {
                                    name: 'Opera',
                                    y: 2.33,
                                    drilldown: 'Opera'
                                },
                                {
                                    name: 'Internet Explorer',
                                    y: 0.45,
                                    drilldown: 'Internet Explorer'
                                },
                                {
                                    name: 'Other',
                                    y: 1.582,
                                    drilldown: null
                                }
                            ]
                        }],
                        drilldown: {
                            breadcrumbs: {
                                position: {
                                    align: 'right'
                                }
                            },
                            series: [{
                                    name: 'Chrome',
                                    id: 'Chrome',
                                    data: [
                                        [
                                            'v65.0',
                                            0.1
                                        ],
                                        [
                                            'v64.0',
                                            1.3
                                        ],
                                        [
                                            'v63.0',
                                            53.02
                                        ],
                                        [
                                            'v62.0',
                                            1.4
                                        ],
                                        [
                                            'v61.0',
                                            0.88
                                        ],
                                        [
                                            'v60.0',
                                            0.56
                                        ],
                                        [
                                            'v59.0',
                                            0.45
                                        ],
                                        [
                                            'v58.0',
                                            0.49
                                        ],
                                        [
                                            'v57.0',
                                            0.32
                                        ],
                                        [
                                            'v56.0',
                                            0.29
                                        ],
                                        [
                                            'v55.0',
                                            0.79
                                        ],
                                        [
                                            'v54.0',
                                            0.18
                                        ],
                                        [
                                            'v51.0',
                                            0.13
                                        ],
                                        [
                                            'v49.0',
                                            2.16
                                        ],
                                        [
                                            'v48.0',
                                            0.13
                                        ],
                                        [
                                            'v47.0',
                                            0.11
                                        ],
                                        [
                                            'v43.0',
                                            0.17
                                        ],
                                        [
                                            'v29.0',
                                            0.26
                                        ]
                                    ]
                                },
                                {
                                    name: 'Firefox',
                                    id: 'Firefox',
                                    data: [
                                        [
                                            'v58.0',
                                            1.02
                                        ],
                                        [
                                            'v57.0',
                                            7.36
                                        ],
                                        [
                                            'v56.0',
                                            0.35
                                        ],
                                        [
                                            'v55.0',
                                            0.11
                                        ],
                                        [
                                            'v54.0',
                                            0.1
                                        ],
                                        [
                                            'v52.0',
                                            0.95
                                        ],
                                        [
                                            'v51.0',
                                            0.15
                                        ],
                                        [
                                            'v50.0',
                                            0.1
                                        ],
                                        [
                                            'v48.0',
                                            0.31
                                        ],
                                        [
                                            'v47.0',
                                            0.12
                                        ]
                                    ]
                                },
                                {
                                    name: 'Internet Explorer',
                                    id: 'Internet Explorer',
                                    data: [
                                        [
                                            'v11.0',
                                            6.2
                                        ],
                                        [
                                            'v10.0',
                                            0.29
                                        ],
                                        [
                                            'v9.0',
                                            0.27
                                        ],
                                        [
                                            'v8.0',
                                            0.47
                                        ]
                                    ]
                                },
                                {
                                    name: 'Safari',
                                    id: 'Safari',
                                    data: [
                                        [
                                            'v11.0',
                                            3.39
                                        ],
                                        [
                                            'v10.1',
                                            0.96
                                        ],
                                        [
                                            'v10.0',
                                            0.36
                                        ],
                                        [
                                            'v9.1',
                                            0.54
                                        ],
                                        [
                                            'v9.0',
                                            0.13
                                        ],
                                        [
                                            'v5.1',
                                            0.2
                                        ]
                                    ]
                                },
                                {
                                    name: 'Edge',
                                    id: 'Edge',
                                    data: [
                                        [
                                            'v16',
                                            2.6
                                        ],
                                        [
                                            'v15',
                                            0.92
                                        ],
                                        [
                                            'v14',
                                            0.4
                                        ],
                                        [
                                            'v13',
                                            0.1
                                        ]
                                    ]
                                },
                                {
                                    name: 'Opera',
                                    id: 'Opera',
                                    data: [
                                        [
                                            'v50.0',
                                            0.96
                                        ],
                                        [
                                            'v49.0',
                                            0.82
                                        ],
                                        [
                                            'v12.1',
                                            0.14
                                        ]
                                    ]
                                }
                            ]
                        }
                    });
                </script>
            </body>


        </div>
        {!! $clientes->links() !!}
    </div>
</div>

@endsection
