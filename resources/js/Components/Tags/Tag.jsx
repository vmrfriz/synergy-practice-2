import { Link } from "@inertiajs/react";
import { tagPostsUrl } from "../../route";

export default function Tag({ tag }) {
    return (
        <Link
            href={tagPostsUrl(tag)}
            className="badge bg-light text-dark border me-2 text-decoration-none"
        >
            #{tag.name}
        </Link>
    )
}
