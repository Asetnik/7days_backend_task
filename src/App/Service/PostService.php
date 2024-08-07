<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;

class PostService
{

    private PostRepository $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $title
     * @param string $content
     * @return void
     */
    public function create(string $title, string $content): void
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);

        $this->repository->add($post, true);
    }
}