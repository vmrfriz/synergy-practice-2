import { Link } from "@inertiajs/react";
import { showPostUrl } from "../../route";
import { pluralize } from "../../utils/helpers";
import { format } from "date-fns";
import Author from "../Author";
import { ru } from "date-fns/locale";

export default function PostItemCompact({ post }) {
    return (
        <div key={post.id}>
            <Link
                href={showPostUrl(post)}
                className="text-decoration-none"
            >
                {post.comments_count > 0 && (
                    <small className="text-muted float-end">
                        {post.comments_count} {pluralize(post.comments_count, ['комментарий', 'комментария', 'комментариев'])}
                    </small>
                )}
                <h5 className="mb-0">{post.title}</h5>
            </Link>

            <div className="text-muted small">
                {post.author && (
                    <><Author user={post.author} /> · </>
                )}
                {post.created_at && (
                    format(post.created_at, 'd MMMM yyyy в H:ii', { locale: ru })
                )}
            </div>

            {post.hidden === true && (
                <span className="badge bg-secondary">
                    Скрыт
                </span>
            )}
        </div>
    );
};
