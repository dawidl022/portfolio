<?php
  class Tech {
    private string $name;
    private string $url;
    private string $imgSrc;

    function __construct(string $name, string $url, string $imgSrc) {
      $this->name = $name;
      $this->url = $url;
      $this->imgSrc = $imgSrc;
    }

    function getName(): string {
      return $this->name;
    }

    function getUrl(): string {
      return $this->url;
    }

    function getImgSrc(): string {
      return $this->imgSrc;
    }
  }
?>
