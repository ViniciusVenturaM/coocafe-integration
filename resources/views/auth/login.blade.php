<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pedidos Coocafe</title>
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--coocafe-dark-text);
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            padding: 40px 30px;
            width: 100%;
            max-w: 420px;
            animation: fadeIn 0.5s ease-out;
        }

        h2 {
            color: var(--coocafe-green);
            text-align: center;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .header-logo {
            height: 35px;
            vertical-align: middle;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: var(--coocafe-green);
            box-shadow: 0 0 0 0.25rem rgba(0, 92, 70, 0.25);
        }

        .btn-primary {
            background-color: var(--coocafe-green);
            border-color: var(--coocafe-green);
            font-weight: 600;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .btn-primary:hover {
            background-color: #004a3a;
            border-color: #004a3a;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 92, 70, 0.3);
        }

        .alert {
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #6c757d;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .form-control-with-icon {
            border-left: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="bg-white p-5 rounded-4 shadow" style="width: 20%; max-w: 450px; border: 1px solid #dee2e6;">
        
        <div class="text-center mb-4">
            <h2 class="d-flex align-items-center justify-content-center gap-2 font-weight-bold" style="color: #005C46; font-size: 1.8rem;">
                <img src="{{ asset('images/logo-cresol.png') }}" alt="logoCresol" style="height: 35px;">
                Pedidos Coocafé
            </h2>
            <small class="text-muted">Autenticação de Usuário</small>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3 text-center" role="alert">
                <i class="fas fa-exclamation-triangle me-1"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.autenticar') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label font-weight-semibold" style="font-size: 0.9rem;">Usuário</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="text" class="form-control form-control-with-icon" id="usuario" name="usuario" placeholder="nome.sobrenome" value="{{ old('usuario') }}" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label font-weight-semibold" style="font-size: 0.9rem;">Senha</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" class="form-control form-control-with-icon" id="password" name="password" placeholder="********" required>
                </div>
            </div>

            <button type="submit" class="btn text-white w-100 py-2.5 font-weight-bold" style="background-color: #005C46; border-radius: 8px;">
                <i class="fas fa-sign-in-alt me-2"></i> Acessar Painel
            </button>
        </form>

    </div>

</body>

</html>