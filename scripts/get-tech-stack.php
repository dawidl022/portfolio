<?php
  require_once 'classes/Tech.class.php';

  /**
   * @return Tech[]
   */
  function getTechStack(): array {
    $baseUrl = "https://raw.githubusercontent.com/dawidl022/dawidl022/main";

    $csv = file_get_contents("$baseUrl/assets/technologies.csv");
    $lines = explode("\n", $csv);
    $techs = [];

    for ($i = 1; $i < count($lines); $i++) {
      $data = explode(",", $lines[$i]);
      if (count($data) != 3) {
        continue;
      }

      if (!(substr($data[2], 0, 8) === "https://")) {
        // icon is in local repo, so should be fetched from there
        $data[2] = $baseUrl . '/' . $data[2];
      }

      $techs[] = new Tech(...$data);
    }
    return $techs;
  }
