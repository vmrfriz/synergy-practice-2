import { useForm } from '@inertiajs/react';

export default function Login({ email, password }) {
    const { data, setData, post, processing, errors } = useForm({
        email: email || '',
        password: password || '',
        remember: false,
    });

    function submit(e) {
        e.preventDefault();

        post('/login');
    }

    return (
        <>
            <div className="row justify-content-center">
                <div className="col-lg-5">
                    <div className="card">
                        <div className="card-body">
                            <h1 className="mb-4">Вход</h1>

                            <form onSubmit={submit}>
                                <div className="mb-3">
                                    <label className="form-label">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        className="form-control"
                                        value={data.email}
                                        onChange={(e) =>
                                            setData('email', e.target.value)
                                        }
                                    />

                                    {errors.email && (
                                        <div className="text-danger small mt-1">
                                            {errors.email}
                                        </div>
                                    )}
                                </div>

                                <div className="mb-3">
                                    <label className="form-label">
                                        Пароль
                                    </label>

                                    <input
                                        type="password"
                                        className="form-control"
                                        value={data.password}
                                        onChange={(e) =>
                                            setData('password', e.target.value)
                                        }
                                    />

                                    {errors.password && (
                                        <div className="text-danger small mt-1">
                                            {errors.password}
                                        </div>
                                    )}
                                </div>

                                <div className="form-check mb-4">
                                    <input
                                        id="remember-me"
                                        type="checkbox"
                                        className="form-check-input"
                                        checked={data.remember}
                                        onChange={(e) =>
                                            setData(
                                                'remember',
                                                e.target.checked
                                            )
                                        }
                                    />

                                    <label htmlFor="remember-me" className="form-check-label">
                                        Запомнить меня
                                    </label>
                                </div>

                                <button
                                    className="btn btn-primary w-100"
                                    disabled={processing}
                                >
                                    Войти
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
