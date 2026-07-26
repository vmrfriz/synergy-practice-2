export function tagPostsUrl(tag) {
    return `/tag/${tag.name}`;
}

export function userPostsUrl(user) {
    return user ? `/author/${user.id}` : '#';
}

export function showPostUrl(post) {
    return `/author/${post.author_id}/${post.slug}`;
}

export function createPostUrl() {
    return `/create-post`;
}

export function editPostUrl(post) {
    return `/author/${post.author_id}/${post.slug}/edit`;
}

export function updatePostUrl(post) {
    return `/author/${post.author_id}/${post.slug}`;
}

export function deletePostUrl(post) {
    return `/author/${post.author_id}/${post.slug}`;
}

export function storeCommentUrl(post) {
    return `/author/${post.author_id}/${post.slug}/comment`;
}

export function profile() {
    return `/profile`;
}

export function subscribe(user) {
    return `/author/${user.id}/subscribe`;
}

export function unsubscribe(user) {
    return `/author/${user.id}/unsubscribe`;
}

export function logout() {
    return `/logout`;
}
