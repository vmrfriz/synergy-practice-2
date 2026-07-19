import { useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    function submit(e) {
        e.preventDefault();

        post('/register');
    }

    return (
        <>
            <div className="row justify-content-center">
                <div className="col-lg-5">
                    <div className="card">
                        <div className="card-body">
                            <h1 className="mb-4">Регистрация</h1>

                            <form onSubmit={submit}>
                                <div className="mb-3">
                                    <label className="form-label">
                                        Имя
                                    </label>

                                    <input
                                        type="text"
                                        className="form-control"
                                        value={data.name}
                                        onChange={(e) =>
                                            setData('name', e.target.value)
                                        }
                                    />
                                </div>

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
                                </div>

                                <div className="mb-4">
                                    <label className="form-label">
                                        Подтверждение пароля
                                    </label>

                                    <input
                                        type="password"
                                        className="form-control"
                                        value={data.password_confirmation}
                                        onChange={(e) =>
                                            setData(
                                                'password_confirmation',
                                                e.target.value
                                            )
                                        }
                                    />
                                </div>

                                <button
                                    className="btn btn-primary w-100"
                                    disabled={processing}
                                >
                                    Зарегистрироваться
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
