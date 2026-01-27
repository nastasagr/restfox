<?php


trait PostsHandler
{
    /**
     * Handler for /restfox/v1/posts
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
}
