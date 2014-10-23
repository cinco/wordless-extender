<?php

class WordlessExtenderConstantForm
{
    private function explode_options( $options )
    {
        $retval = '';

        if (!is_array($options))
            throw new Exception('Expected $options to be an array', 1);
        foreach ($options as $key => $value) {
            $retval .= "{$key}=\"{$value}\" ";
        }

        return $retval;
    }

    private function input( $options )
    {
        $label = ( isset($options['label']) ) ? $options['label'] : '';
        $checked = ( isset($options['checked'] ) && $options['checked'] == $options['value']) ? 'checked' : '';
        $value = ( isset($options['value']) ) ? $options['value'] : '';

        return "<input {$checked} type=\"{$options['type']}\" name=\"{$options['name']}\" value=\"{$value}\" > {$label}";
    }

    private function td( $content )
    {
        echo '<td>' . $content . '</td>';
    }

    private function tr_open()
    {
        echo '<tr>';
    }

    private function tr_close()
    {
        echo '</tr>';
    }

    private function parse_input_type( $name, $inputType, $constantObj )
    {
        $ret = array();

        if ( is_null($inputType) || $inputType == 'text' ){
            $ret[] = array(
                "type" => 'text',
                "name" => $name,
                "value" => $constantObj->get_value(),
                'label' => ''
            );
        } elseif ( $inputType == 'bool' ) {
            $ret[] = array(
                "type" => 'radio',
                "name" => $name,
                "value" => 'true',
                'label' => 'true'
            );
            $ret[] = array(
                "type" => 'radio',
                "name" => $name,
                "value" => 'false',
                'label' => 'false'
            );

            foreach ($ret as &$array) {
                $array['checked'] = $constantObj->get_value();
            }
        } else {
            wle_show_message("Unsupported type of input for the constant {$name}", true);
            return false;
        }

        return $ret;
    }

    public function print_row( $name, $args = array('type' => null, 'description' => ''))
    {

        if ( !is_array($args) ){
            $args = array('type' => null, 'description' => '');
        }

        $inputType = $args['type'];
        $description = $args['description'];

        $html = '';
        $cmanager = WordlessExtenderConstantManager::get_instance();

        $constantObj = $cmanager->init_constant($name);
        if (!empty($description))
            $constantObj->set_description($description);

        $inputs = $this->parse_input_type( $name, $inputType, $constantObj );

        $this->tr_open();
        $this->td($constantObj->get_name());
        $this->td($constantObj->get_description());

        foreach ($inputs as $input) {
            $html .= $this->input( $input );
        }
            $this->td( $html );

        $this->td($this->input(array(
                "type" => "checkbox",
                "name" => "reset-{$name}"
            )));

        $this->tr_close();
    }


}
