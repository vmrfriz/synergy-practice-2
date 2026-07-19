export function tagPostsUrl(tag) {
    return `/tags/${tag.name}`;
}

export function userPostsUrl(user) {
    return `/author/${user.id}`;
}

export function showPostUrl(post) {
    return `/${post.author_id}/${post.slug}`;
}

export function editPostUrl(post) {
    return `/${post.author_id}/${post.slug}/edit`;
}

export function deletePostUrl(post) {
    return `/${post.author_id}/${post.slug}`;
}

export function profile(user = null) {
    return user === null
        ? `/profile`
        : `/profile/${user.id}`;
}

export function subscribe(user) {
    return `/profile/${user.id}/subscribe`;
}

export function unsubscribe(user) {
    return `/profile/${user.id}/unsubscribe`;
}
