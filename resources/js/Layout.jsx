import { Link } from "@inertiajs/react"

export default function Layout({ children }) {
    return (
        <main>
            <header>
                <Link href="/">Главная</Link>
                <Link href="/login">Вход</Link>
                <Link href="/register">Регистрация</Link>
            </header>
            <article>{children}</article>
        </main>
    )
}
