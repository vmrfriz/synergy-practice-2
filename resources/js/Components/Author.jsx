import { Link } from "@inertiajs/react";
import { userPostsUrl } from "../route";

export default function Author({ user }) {
    return (
        <Link href={userPostsUrl(user)}>{user?.name}</Link>
    );
};
