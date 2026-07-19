import { Link } from "@inertiajs/react";

export default function Pagination({ links }) {
    return (
        <nav>
            <ul className="pagination">
                {links.map((link, index) => (
                    <li
                        key={index}
                        className={`page-item ${
                            link.active ? 'active' : ''
                        } ${!link.url ? 'disabled' : ''}`}
                    >
                        <Link
                            href={link.url || '#'}
                            className="page-link"
                            dangerouslySetInnerHTML={{
                                __html: link.label,
                            }}
                        />
                    </li>
                ))}
            </ul>
        </nav>
    )
}
