<?php


trait PostsHandler
{
    /**
     * Handler for /restfox/v1/posts
     *   @method GET
     */

    public function get_posts()
    {

        $show_posts = (int) get_option('restfox_show_posts', 0);

        if (! $show_posts) {
            return new WP_Error(
                'rest_forbidden',
                'This feature is disabled by RestFox API settings',
                ['status' => 403]
            );
        }

        $posts = get_posts();
        $data  = [];

        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->ID,
                'title'  => $post->post_title,
                'author' => get_the_author_meta('display_name', $post->post_author),
            ];
        }

        return [
            'posts' => $data,
        ];
    }


    /**
     * Handler for /restfox/v1/posts/{postID}
     * @method DELETE
     */
    public function delete_post( WP_REST_Request $request ) {

        $post_id = (int) $request->get_param('postID');

        if ( ! $post_id ) {
            return new WP_Error(
                'missing_post_id',
                'Post ID is required',
                [ 'status' => 400 ]
            );
        }

        if ( ! get_post( $post_id ) ) {
            return new WP_Error(
                'post_not_found',
                'Post not found',
                [ 'status' => 404 ]
            );
        }

        if ( ! current_user_can( 'delete_post', $post_id ) ) {
            return new WP_Error(
                'forbidden',
                'You are not allowed to delete this post',
                [ 'status' => 403 ]
            );
        }

        $deleted = wp_delete_post( $post_id, true );

        if ( ! $deleted ) {
            return new WP_Error(
                'delete_failed',
                'Post could not be deleted',
                [ 'status' => 500 ]
            );
        }

        return [
            'success' => true,
            'post_id' => $post_id,
        ];
    }
}
