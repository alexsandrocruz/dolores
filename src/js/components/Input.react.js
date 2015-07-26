"use strict";

var _ = require("lodash");
var React = require("react");
var cx = require("classnames");

var Input = React.createClass({
  getInitialState: function() {
    return {
      focused: false,
      suggestions: [
        "Avesso da montanha",
        "Labirinto",
        "Contra-senha",
        "Cara a tapa",
        "Penha",
        "Irajá",
        "Olaria",
        "Vigário Geral",
        "Piedade"
      ],
      selectedSuggestion: null
    };
  },

  render: function() {
    var className = cx(this.props.className, {focused: this.state.focused});
    return (
      <div className={className}>
        {this.renderInput()}
        {this.renderSuggestions()}
      </div>
    );
  },

  renderInput: function() {
    var onBlur = _.debounce(function() {
      this.setState({
        focused: false,
        selectedSuggestion: null
      });
    }.bind(this), 100);

    var onChange = function(e) {
      this.props.onChange(this.props.name, e.target.value);
    }.bind(this);

    var onFocus = function() {
      this.setState({focused: true});
    }.bind(this);

    var blur = function() {
      React.findDOMNode(this.refs.input).blur();
    }.bind(this);

    var useSuggestion = function() {
      if (_.isNumber(this.state.selectedSuggestion)) {
        this.props.onChange(
            this.props.name,
            this.state.suggestions[this.state.selectedSuggestion]
        );
      }
      blur();
    }.bind(this);

    var setSuggestion = function(delta) {
      var mod = this.state.suggestions.length;
      var newIndex;
      if (_.isNumber(this.state.selectedSuggestion)) {
        newIndex = (this.state.selectedSuggestion + mod + delta) % mod;
      } else {
        if (delta > 0) {
          newIndex = delta - 1;
        } else {
          newIndex = (mod + delta) % mod;
        }
      }
      this.setState({
        selectedSuggestion: newIndex
      });
    }.bind(this);

    var onKey = function(e) {
      if (this.props.suggestions) {
        switch (e.which) {
          case 13: // Enter
            useSuggestion();
            e.preventDefault();
            break;
          case 27: // Esc
            blur();
            e.preventDefault();
            break;
          case 40: // Down
            setSuggestion(1);
            e.preventDefault();
            break;
          case 38: // Up
            setSuggestion(-1);
            e.preventDefault();
            break;
        }
      }
    }.bind(this);

    return <input
        disabled={this.props.disabled}
        name={this.props.name}
        onBlur={onBlur}
        onChange={onChange}
        onFocus={onFocus}
        onKeyDown={onKey}
        type={this.props.type}
        placeholder={this.props.placeholder}
        ref="input"
        value={this.props.value}
        />;
  },

  renderSuggestions: function() {
    if (!this.props.suggestions) {
      return null;
    }

    return <ul className="suggestions">
      {this.state.suggestions.map(this.renderSuggestion)}
    </ul>;
  },

  renderSuggestion: function(suggestion, index) {
    var onClick = function(e) {
      this.props.onChange(this.props.name, e.target.innerHTML);
    }.bind(this);

    var className = cx({selected: index === this.state.selectedSuggestion});

    return <li key={suggestion} onClick={onClick} className={className}>
      {suggestion}
    </li>;
  }
});

module.exports = Input;