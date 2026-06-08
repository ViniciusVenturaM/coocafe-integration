<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos Coocafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo-cresol.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
    @csrf
    <button type="submit" class="btn btn-outline-danger" style="border-radius: 8px; padding: 10px 20px; font-weight: 600;">
        <i class="fas fa-sign-out-alt me-2"></i> Sair
    </button>
</form>
    <style>
        :root {
            --coocafe-orange: #F58220;
            --coocafe-green: #005C46;
            --coocafe-light-green: #e0f2f1;
            --coocafe-dark-text: #333;
            --coocafe-light-text: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
            color: var(--coocafe-dark-text);
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: 30px;
        }

        h1 {
            color: var(--coocafe-green);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        h1 i {
            color: var(--coocafe-orange);
        }

        .alert {
            border-radius: 8px;
            font-weight: 500;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-primary {
            background-color: var(--coocafe-green);
            border-color: var(--coocafe-green);
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #004a3a;
            border-color: #004a3a;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 92, 70, 0.3);
        }

        .btn-info {
            background-color: #ffffffff;
            border-color: var(--coocafe-orange);
            color: var(--coocafe-light-text);
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-info:hover {
            background-color: #ffffff;
            border-color: #d86f1a;
        }

        .btn-info i {
            color: red;
        }

        .btn-warning {
            background-color: #F58220;
            border-color: #ffc107;
            color: var(--coocafe-dark-text);
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }

        .table {
            margin-top: 25px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background-color: var(--coocafe-green);
            color: var(--coocafe-light-text);
        }

        .table th {
            padding: 15px 12px;
            font-weight: 600;
            border-bottom: none;
        }

        .table tbody tr {
            transition: background-color 0.2s ease-in-out;
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--coocafe-light-green);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 92, 70, 0.1);
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .modal-header {
            background-color: var(--coocafe-green);
            color: var(--coocafe-light-text);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 20px;
            justify-content: flex-end;
        }

        .modal-footer .btn-success {
            background-color: #004a3a;
            border-color: #004a3a;
        }

        .modal-footer .btn-success:hover {
            background-color: var(--coocafe-orange);
            border-color: var(--coocafe-orange);

        }

        .form-select {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 8px 12px;
        }

        .header-logo {
            height: 40px;
            margin-right: 15px;
            vertical-align: middle;
        }

        h1 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            </div>
        @endif
        <h1>
            <img src="{{ asset('images/logo-cresol.png') }}" alt="logoCresol" class="header-logo">
            Pedidos Coocafé
        </h1>

        <div class="mb-4 d-flex justify-content-start">
            <a href="{{ route('pedidos.index') }}" class="btn btn-primary">
                <i class="fas fa-sync-alt me-2"></i> Atualizar Pedidos
            </a>
        </div>

        @if (!$pedidos || count($pedidos) === 0)
            <div class="alert alert-info text-center" role="alert">
                <i class="fas fa-info-circle me-2"></i> Nenhum pedido encontrado. Clique em "Atualizar Pedidos" para
                tentar carregar.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nº Pedido</th>
                            <th>Cliente</th>
                            <th>Tipo Pessoa</th>
                            <th>CPF/CNPJ</th>
                            <th>Valor Líquido</th>
                            <th>Situação</th>
                            <th>Data Emissão</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos->sortByDesc('NUMPED') as $pedido)
                            <tr>
                                <td>{{ $pedido['NUMPED'] }}</td>
                                <td>{{ $pedido['NOMCLI'] }}</td>
                                <td>{{ $pedido['TIPCLI'] }}</td>
                                <td>{{ $pedido['CGCCPF'] }}</td>
                                <td>R$ {{ number_format($pedido['VLRLIQ'], 2, ',', '.') }}</td>
                                <td>{{ $pedido['BANSIT'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($pedido['DATEMI'])->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pedidos.pdf', ['numped' => $pedido['NUMPED']]) }}"
                                        target="_blank" class="btn btn-sm btn-info me-2" title="Ver PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning update-status-btn"
                                        data-bs-toggle="modal" data-bs-target="#updateStatusModal"
                                        data-numped="{{ $pedido['NUMPED'] }}"
                                        data-currentstatus="{{ $pedido['BANSIT'] }}" title="Atualizar Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modal para Atualizar Status --}}
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Atualizar Status do Pedido <span
                            id="modal-numped-display"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateStatusForm" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new-status-select" class="form-label">Novo Status:</label>
                            <select class="form-select" id="new-status-select" name="bansit" required>
                                <option value="">Selecione um status</option>
                                <option value="E">E - Em Análise</option>
                                <option value="A">A - Aprovado</option>
                                <option value="L">L - Liberado</option>
                                <option value="R">R - Reprovado</option>
                                <option value="C">C - Cancelado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusModal = document.getElementById('updateStatusModal');
            const modalNumpedDisplay = document.getElementById('modal-numped-display');
            const updateStatusForm = document.getElementById('updateStatusForm');
            const newStatusSelect = document.getElementById('new-status-select');

            let currentNumped = null;

            updateStatusModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                currentNumped = button.getAttribute('data-numped');
                const currentStatus = button.getAttribute('data-currentstatus');

                modalNumpedDisplay.textContent = currentNumped;
                newStatusSelect.value = currentStatus;
            });

            updateStatusForm.addEventListener('submit', function(event) {
                const selectedStatus = newStatusSelect.value;

                if (!selectedStatus) {
                    alert('Por favor, selecione um status.');
                    event.preventDefault();
                    return;
                }

                if (!currentNumped) {
                    alert('Erro: Número do pedido não encontrado.');
                    event.preventDefault();
                    return;
                }

                const baseUrl = '{{ url('api/atualiza-status-pedido') }}';
                const finalUrl = `${baseUrl}/${currentNumped}/${selectedStatus}`;

                window.location.href = finalUrl;

                event.preventDefault();
            });
        });
    </script>
</body>

</html>
