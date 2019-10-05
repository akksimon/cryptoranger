<?php
namespace OCFram;

class SelectField extends Field
{
  
  public function buildWidget()
  {
    $widget = '';
    
    if (!empty($this->errorMessage))
    {
      $widget .= $this->errorMessage.'<br />';
    }
    
    $widget .= '<div class="form-group">'.'<label>'.$this->label.'</label><select class="form-control" name="'.$this->name.'"><option value="news">news</option><option value="getstarted"'; 
    
    if ($this->value === 'getstarted'){
     $widget .= 'selected';
    }
    
    $widget .= '>get started</option><option value="trading" ';
    
    if ($this->value === 'trading'){
     $widget .= 'selected';
    }
    
    $widget .= '>trading</option><option value="fundamentals"';
    
    if ($this->value === 'fundamentals'){
     $widget .= 'selected';
    }
    
    $widget .= '>fundamentals</option>';    
    
    return $widget .= '</select>'.'</div>';
  }
}