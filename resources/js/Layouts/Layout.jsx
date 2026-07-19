import { Link, usePage } from '@inertiajs/react';

export default function Layout({ children }) {
    const { auth } = usePage().props;

    const user = auth?.user;

    return (
        <>
            <nav className="navbar navbar-expand-lg bg-body-tertiary border-bottom">
                <div
                    className="container-fluid"
                    style={{ maxWidth: '1024px' }}
                >
                    <Link className="navbar-brand fw-bold" href="/">
                        Блог
                    </Link>

                    <button
                        className="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbar"
                    >
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    <div className="collapse navbar-collapse" id="navbar">
                        <ul className="navbar-nav ms-auto align-items-lg-center">
                            {!user && (
                                <>
                                    <li className="nav-item">
                                        <Link
                                            href="/login"
                                            className="nav-link"
                                        >
                                            Вход
                                        </Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link
                                            href="/register"
                                            className="nav-link"
                                        >
                                            Регистрация
                                        </Link>
                                    </li>
                                </>
                            )}

                            {user && (
                                <>
                                    <li className="nav-item">
                                        <Link
                                            href="/posts/create"
                                            className="nav-link"
                                        >
                                            Создать запись
                                        </Link>
                                    </li>

                                    <li className="nav-item">
                                        <Link
                                            href="/profile"
                                            className="nav-link fw-semibold"
                                        >
                                            {user.name}
                                        </Link>
                                    </li>
                                </>
                            )}
                        </ul>
                    </div>
                </div>
            </nav>

            <main
                className="container-fluid py-4"
                style={{ maxWidth: '1024px' }}
            >
                {children}
            </main>
        </>
    );
}
