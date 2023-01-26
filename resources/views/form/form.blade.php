{{-- route = http://127.0.0.1:8000/form/{urlToken} --}}
<x-layout>



    @isset($error)

        {{-- display the error message --}}
        {{ $error }}

    @else
        {{-- no errors --}}
    
        @isset($form)

            {{-- display form --}}
            <?php
                $form = json_decode($form["questions"], true);
                
                // $title = $form["questions"]["title"];
                // $questions = $form["questions"]["questions"];
            ?>
            <h1>{{ $form["title"] }}</h1><br><br><br>
            <form>
            <?php
                for($i=0;$i<count($form["questions"]);$i++){
                    if($form["questions"][$i]["type"] == 1){
                        echo("<br><br>");
                        echo($form["questions"][$i]["question_title"]."<br>");
                        echo("<input name=".$i." type='text' placeholder='".$form["questions"][$i]["placeholder"]."'/>");
                    }else if($form["questions"][$i]["type"] == 2){
                        echo("<br><br>");
                        echo($form["questions"][$i]["question_title"]."<br>");
                        for($j=0;$j<count($form["questions"][$i]["choices"]);$j++){
                            echo("<input name=".$i."  type='radio' value='".$form["questions"][$i]["choices"][$j]."'/>");
                            echo($form["questions"][$i]["choices"][$j]."<br>");
                        }
                    }else if($form["questions"][$i]["type"] == 3){
                        echo("<br><br>");
                        echo($form["questions"][$i]["question_title"]."<br>");
                        for($j=0;$j<count($form["questions"][$i]["choices"]);$j++){
                            echo("<input name=".$i." type='checkbox' value='".$form["questions"][$i]["choices"][$j]."'/>");
                            echo($form["questions"][$i]["choices"][$j]."<br>");
                        }
                    }

                }
            ?>
            </form>

        @else

            {{-- display a no form found error message --}}
            No form found!
            
        @endisset

    @endisset



</x-layout>
