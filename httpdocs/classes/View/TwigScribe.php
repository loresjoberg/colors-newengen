<?php

namespace LoreSjoberg\View;

class TwigScribe implements ScribeInterface
{
    /** @var \Twig_Environment  */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $template
     * @param $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function display($template, $data = '') {
        $this->twig->display($template . '.twig', $this->decode_data($data));
    }

    /**
     * @param $template
     * @param $data
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($template, $data = '') {
        return $this->twig->render($template . '.twig', $this->decode_data($data));
    }

    /**
     * @param $data
     * @return array
     */
    public function decode_data($data)
    {
        if (empty($data)) {
            $data = [];
        } else {
            $data = json_decode($data, JSON_OBJECT_AS_ARRAY);
        }
        return $data;
    }
}