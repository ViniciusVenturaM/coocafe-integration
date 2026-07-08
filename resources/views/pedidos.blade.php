<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos Coocafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo-cresol.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

        .container-fluid {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: 10px;
        }


        .header-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }

        h1 {
            color: var(--coocafe-green);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        .header-logo {
            height: 40px;
        }

        .logout-form {
            position: absolute;
            right: 0;
            margin: 0;
        }


        .btn-primary {
            background-color: var(--coocafe-green);
            border-color: var(--coocafe-green);
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary:hover {
            background-color: #004a3a;
            border-color: #004a3a;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 92, 70, 0.3);
            color: white;
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
            border-color: #F58220;
            color: white;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #d86f1a;
            border-color: #d86f1a;
            color: white;
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
            background-color: rgba(0, 92, 70, 0.1) !important;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .input-controle {
            min-width: 200px;
        }
    </style>
</head>

<body>
    <div class="container-fluid px-4">
        <div class="header-container">
            <h1>
                <img src="{{ asset('images/logo-cresol.png') }}" alt="logoCresol" class="header-logo">
                Pedidos Coocafé
            </h1>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-outline-danger"
                    style="border-radius: 8px; padding: 8px 20px; font-weight: 600;">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                </button>
            </form>
        </div>

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
                            <th>CPF/CNPJ</th>
                            <th>Valor Líquido</th>
                            <th>Situação</th>
                            <th>Data Emissão</th>
                            <th>Nº Processo Fluid</th>
                            <th class="text-center">Processo finalizado?</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pedidos->sortByDesc('NUMPED') as $pedido)
                            <tr>
                                <td><strong>{{ $pedido['NUMPED'] }}</strong></td>
                                <td>{{ $pedido['NOMCLI'] }}</td>
                                <td>{{ $pedido['CGCCPF'] }}</td>
                                <td>R$ {{ number_format($pedido['VLRLIQ'], 2, ',', '.') }}</td>
                                <td>{{ $pedido['BANSIT'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($pedido['DATEMI'])->format('d/m/Y') }}</td>
                                <td>
                                    <div class="input-group input-group-sm" style="min-width: 150px;">
                                        <input type="text" class="form-control input-processo"
                                            id="processo_{{ $pedido['NUMPED'] }}" placeholder="Nº Processo"
                                            value="{{ $pedido['num_processo'] ?? '' }}">
                                        <button class="btn btn-outline-secondary btn-save-processo" type="button"
                                            data-numped="{{ $pedido['NUMPED'] }}" title="Salvar Controle">
                                            <i class="fas fa-save" style="color: var(--coocafe-green);"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="form-check d-flex justify-content-center mb-0"
                                        title="Chamado Finalizado?">
                                        <input class="form-check-input check-chamado" type="checkbox"
                                            id="check_{{ $pedido['NUMPED'] }}"
                                            {{ isset($pedido['chamado_finalizado']) && $pedido['chamado_finalizado'] ? 'checked' : '' }}
                                            style="transform: scale(1.3); cursor: pointer; border-color: #aaa;">
                                    </div>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('pedidos.pdf', ['numped' => $pedido['NUMPED']]) }}"
                                        target="_blank" class="btn btn-sm btn-info me-1" title="Ver PDF">
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

            if (updateStatusModal) {
                updateStatusModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    currentNumped = button.getAttribute('data-numped');
                    const currentStatus = button.getAttribute('data-currentstatus');

                    modalNumpedDisplay.textContent = currentNumped;
                    newStatusSelect.value = currentStatus;
                });

                updateStatusForm.addEventListener('submit', function(event) {
                    const selectedStatus = newStatusSelect.value;
                    if (!selectedStatus || !currentNumped) {
                        alert('Erro: Verifique se o pedido e o status foram selecionados.');
                        event.preventDefault();
                        return;
                    }
                    const baseUrl = '{{ url('api/atualiza-status-pedido') }}';
                    window.location.href = `${baseUrl}/${currentNumped}/${selectedStatus}`;
                    event.preventDefault();
                });
            }

            const saveProcessButtons = document.querySelectorAll('.btn-save-processo');

            saveProcessButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const numped = this.getAttribute('data-numped');

                    const isChamadoAberto = document.getElementById(`check_${numped}`).checked ? 1 :
                        0;
                    let numProcesso = document.getElementById(`processo_${numped}`).value.trim();

                    if (numProcesso === '') {
                        numProcesso = 'nenhum';
                    }

                    const baseUrl = '{{ url('api/atualiza-controle-pedido') }}';

                    const finalUrl =
                        `${baseUrl}/${numped}/${encodeURIComponent(numProcesso)}/${isChamadoAberto}?t=${new Date().getTime()}`;
                    window.location.href = finalUrl;
                });
            });

        });
    </script>
</body>

</html>
