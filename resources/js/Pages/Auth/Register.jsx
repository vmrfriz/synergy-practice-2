import { useForm } from '@inertiajs/react';
import CustomInput from '../../Components/CustomInput';

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

    const bind = (name) => ({
        value: data[name],
        error: errors[name],
        onChange: (value) => setData(name, value)
    });

    return (
        <>
            <div className="row justify-content-center">
                <div className="col-lg-5">
                    <div className="card">
                        <div className="card-body">
                            <h1 className="mb-4">Регистрация</h1>

                            <form onSubmit={submit}>
                                <CustomInput {...bind('name')}>Имя</CustomInput>
                                <CustomInput {...bind('email')} type="email">Email</CustomInput>
                                <CustomInput {...bind('password')} type="password">Пароль</CustomInput>
                                <CustomInput {...bind('password_confirmation')} type="password">Подтверждение пароля</CustomInput>

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
