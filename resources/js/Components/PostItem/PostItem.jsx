import { Link } from "@inertiajs/react";
import { format } from 'date-fns';
import { ru } from 'date-fns/locale';
import { showPostUrl, tagPostsUrl } from "../../route.js";
import Tags from "../Tags/Tags.jsx";
import Author from "../Author.jsx";

export default function PostItem({ post }) {
    return (
        <div className="card">
            <div className="card-body">
                <Link
                    href={showPostUrl(post)}
                    className="text-decoration-none text-dark"
                >
                    <h3>{post.title}</h3>
                </Link>

                <div className="small text-muted mb-3">
                    <Author user={post.author} /> · {post.created_at ? format(post.created_at, 'd MMMM yyyy', { locale: ru }) : ''}
                </div>

                <Tags tags={post.tags} className="mb-3" />

                <div>
                    {post.content}...
                    <Link
                        href={showPostUrl(post)}
                        className="text-decoration-none"
                    >
                        Читать далее &rarr;
                    </Link>
                </div>
            </div>
        </div>
    )
}
