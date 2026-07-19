import { Link } from "@inertiajs/react";
import { userPostsUrl } from "../../route";

export default function Subscription({ user }) {
    return (
        <Link href={userPostsUrl(user)} key={user.id} className="list-group-item d-flex align-items-center justify-content-between">
            <div>
                <div className="fw-semibold">
                    {user.name}
                </div>

                <div className="small text-muted">
                    Записей: {user.posts_count}
                </div>
            </div>

            <button type="button" className="btn btn-sm btn-outline-secondary float-end">
                Отписаться
            </button>
        </Link>
    );
}
