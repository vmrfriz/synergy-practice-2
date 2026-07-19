import { Link } from "@inertiajs/react";
import SubscriptionButton from "./SubscriptionButton";
import { userPostsUrl } from "../../route";

export default function Subscription({ user }) {

    return (
        <div className="list-group-item d-flex align-items-center justify-content-between">
            <Link href={userPostsUrl(user)} key={user.id} className="text-decoration-none w-100">
                <div>
                    <div className="fw-semibold">
                        {user.name}
                    </div>

                    <div className="small text-muted">
                        Записей: {user.posts_count}
                    </div>
                </div>
            </Link>

            <SubscriptionButton user={user} />
        </div>
    );
}
